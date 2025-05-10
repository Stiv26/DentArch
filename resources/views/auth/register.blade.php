@include('components.header')

<div class="container-fluid vh-100 d-flex justify-content-center align-items-center">
    <div class="col-12 col-md-8 col-lg-6 col-xl-4">
        <div class="card bg-dark text-white border-secondary shadow-lg">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <i class="bi bi-tooth fs-1 text-primary"></i>
                    <img src="{{ asset('images/logo.jpg') }}" alt="DentArch Logo" class="mb-3" width="100%">
                    <p class="text-secondary">Create new account</p>
                </div>

                <form method="POST" action="{{ route('register.store') }}">
                    @csrf
                    <!-- Name Input -->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="name"
                            name="name" placeholder="Your Name" required>
                        <label for="name" class="text-secondary">Full Name</label>
                    </div>

                    <!-- Email Input -->
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control bg-dark text-white border-secondary" id="email"
                            name="email" placeholder="name@example.com" required>
                        <label for="email" class="text-secondary">Email address</label>
                    </div>

                    <!-- Password Input -->
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control bg-dark text-white border-secondary" id="password"
                            name="password" placeholder="Password" required>
                        <label for="password" class="text-secondary">Password</label>

                        <span class="position-absolute top-50 end-0 translate-middle-y me-3"
                            onclick="togglePassword('password', 'iconPassword')" style="cursor: pointer;">
                            <i class="bi bi-eye-slash text-secondary" id="iconPassword"></i>
                        </span>
                    </div>

                    <!-- Tambahkan Password Confirmation -->
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control bg-dark text-white border-secondary"
                            id="password_confirmation" name="password_confirmation" placeholder="Confirm Password"
                            required>
                        <label for="password_confirmation" class="text-secondary">Confirm Password</label>

                        <span class="position-absolute top-50 end-0 translate-middle-y me-3"
                            onclick="togglePassword('password_confirmation', 'iconConfirm')" style="cursor: pointer;">
                            <i class="bi bi-eye-slash text-secondary" id="iconConfirm"></i>
                        </span>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Register Button -->
                    <button class="w-100 btn btn-lg btn-primary my-3" type="submit">Register</button>

                    <!-- Login Link -->
                    <div class="text-center text-secondary mt-4">
                        Already have an account?
                        <a href="login" class="text-primary text-decoration-none">Sign in</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        }
    }
</script>

@include('components.footer')
