<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Tu cuenta ha sido desactivada. Contacta al administrador.']);
            }

            $user->update(['last_login_at' => now()]);
            $request->session()->regenerate();

            return redirect($this->redirectByRole($user))
                ->with('success', '¡Bienvenido de vuelta, ' . $user->name . '!');
        }

        return back()
            ->withErrors(['email' => 'Las credenciales no son correctas.'])
            ->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'student',
        ]);

        Auth::login($user);

        return redirect()->route('student.dashboard')
            ->with('success', '¡Bienvenido al INCES LMS! Tu cuenta fue creada exitosamente.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Has cerrado sesión correctamente.');
    }

    protected function redirectByRole(User $user): string
    {
        return match($user->role) {
            'admin'      => route('admin.dashboard'),
            'instructor' => route('instructor.dashboard'),
            default      => route('student.dashboard'),
        };
    }
}
