<!-- show success and success message -->
@if (session('success'))
<p class="alert alert-success text-center">{{ session('success') }}</p>
@endif
<!-- show success and error message -->
@if (session('error'))
<p class="alert alert-danger text-center">{{ session('error') }}</p>
@endif