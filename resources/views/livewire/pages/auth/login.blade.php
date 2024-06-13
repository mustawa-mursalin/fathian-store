<?php
	
	use App\Livewire\Forms\LoginForm;
	use Illuminate\Support\Facades\Session;
	use Livewire\Attributes\Layout;
	use Livewire\Volt\Component;
	
	new class extends Component {
		public LoginForm $form;
		
		/**
		 * Handle an incoming authentication request.
		 */
		public function login() : void
		{
			$this->validate();
			
			$this->form->authenticate();
			
			Session::regenerate();
			
			$this->redirectIntended(default : route('dashboard', absolute : false), navigate : true);
		}
	}; ?>
<div>
	<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
		<div class="flex h-full items-center">
			<main class="w-full max-w-md mx-auto p-6">
				<div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
					<div class="p-4 sm:p-7">
						<div class="text-center">
							<h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Sign in</h1>
							<p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
								Don't have an account yet?
								<a class="text-blue-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
								   href="/register">
									Sign up here
								</a>
							</p>
						</div>
						
						<hr class="my-5 border-slate-300">
						
						<!-- Form -->
						<form wire:submit="login">
							<div class="grid gap-y-4">
								<!-- Form Group -->
								<div>
									<label for="email" class="block text-sm mb-2 dark:text-white">Email address</label>
									<div class="relative">
										<input type="email" wire:model="form.email" id="email" name="email"
										       autofocus autocomplete="username"
										       class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
										       required aria-describedby="email-error">
										<div class="hidden absolute inset-y-0 end-0 items-center pointer-events-none pe-3">
											<svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"
											     aria-hidden="true">
												<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
											</svg>
										</div>
									</div>
									<x-input-error :messages="$errors->get('form.email')" class="mt-2" />
									<p class="hidden text-xs text-red-600 mt-2" id="email-error">Please include a valid email address so
									                                                             we
									                                                             can get back to you</p>
								</div>
								<!-- End Form Group -->
								
								<!-- Form Group -->
								<div>
									<div class="flex justify-between items-center">
										<label for="password" class="block text-sm mb-2 dark:text-white">Password</label>
										<a class="text-sm text-blue-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
										   href="/forgot">Forgot password?</a>
									</div>
									<div class="relative">
										<input wire:model="form.password" id="password"
										       type="password"
										       name="password"
										       autocomplete="current-password"
										       class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
										       required aria-describedby="password-error">
										<div class="hidden absolute inset-y-0 end-0 items-center pointer-events-none pe-3">
											<svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"
											     aria-hidden="true">
												<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
											</svg>
										</div>
									</div>
									<p class="hidden text-xs text-red-600 mt-2" id="password-error">8+ characters required</p>
								</div>
								<!-- End Form Group -->
								<button type="submit"
								        class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
									Sign in
								</button>
							</div>
						</form>
						<!-- End Form -->
					</div>
				</div>
			</main>
		</div>
	</div>
	
	
	<!-- Session Status -->
	<x-auth-session-status class="mb-4" :status="session('status')" />
	
	<form wire:submit="login">
		<!-- Email Address -->
		<div>
			<x-input-label for="email" :value="__('Email')" />
			<x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required
			              autofocus autocomplete="username" />
			<x-input-error :messages="$errors->get('form.email')" class="mt-2" />
		</div>
		
		<!-- Password -->
		<div class="mt-4">
			<x-input-label for="password" :value="__('Password')" />
			
			<x-text-input wire:model="form.password" id="password" class="block mt-1 w-full"
			              type="password"
			              name="password"
			              required autocomplete="current-password" />
			
			<x-input-error :messages="$errors->get('form.password')" class="mt-2" />
		</div>
		
		<!-- Remember Me -->
		<div class="block mt-4">
			<label for="remember" class="inline-flex items-center">
				<input wire:model="form.remember" id="remember" type="checkbox"
				       class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
				       name="remember">
				<span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
			</label>
		</div>
		
		<div class="flex items-center justify-end mt-4">
			@if (Route::has('password.request'))
				<a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
				   href="{{ route('password.request') }}" wire:navigate>
					{{ __('Forgot your password?') }}
				</a>
			@endif
			
			<x-primary-button class="ms-3">
				{{ __('Log in') }}
			</x-primary-button>
		</div>
	</form>
</div>
