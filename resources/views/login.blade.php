@include('components.header')

<div class="container-fluid vh-100 d-flex justify-content-center align-items-center">
    <div class="col-12 col-md-8 col-lg-6 col-xl-4">
        <div class="card bg-dark text-white border-secondary shadow-lg">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <i class="bi bi-tooth fs-1 text-primary"></i>
                    <img src="{{ asset('images/logo.jpg') }}" alt="DentArch Logo" class="mb-3" width="100%">
                    <p class="text-secondary">Please sign in to continue</p>
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

                <form method="POST" action="{{ route('login.authenticate') }}">
                    @csrf
                    <!-- Email Input -->
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control bg-dark text-white border-secondary" id="email"
                            placeholder="name@example.com" name="email">
                        <label for="email" class="text-secondary">Email address</label>
                    </div>

                    <!-- Password Input -->
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control bg-dark text-white border-secondary" id="password"
                            placeholder="Password" name="password">
                        <label for="password" class="text-secondary">Password</label>

                        <span class="position-absolute top-50 end-0 translate-middle-y me-3" onclick="togglePassword()"
                            style="cursor: pointer;">
                            <i class="bi bi-eye-slash text-secondary" id="toggleIcon"></i>
                        </span>
                    </div>

                    <!-- Login Button -->
                    <button class="w-100 btn btn-lg btn-primary my-3" type="submit">Sign in</button>

                    <!-- Sign Up Link -->
                    <div class="text-center text-secondary mt-4">
                        Don't have an account?
                        <a href="register" class="text-primary text-decoration-none">Register</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- Script -->
<script>
    function togglePassword() {
        const password = document.getElementById("password");
        const icon = document.getElementById("toggleIcon");
        if (password.type === "password") {
            password.type = "text";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        } else {
            password.type = "password";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        }
    }
</script>

@include('components.footer')
