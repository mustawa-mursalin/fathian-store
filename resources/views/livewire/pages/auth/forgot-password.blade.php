<?php
	
	use Illuminate\Support\Facades\Password;
	use Livewire\Attributes\Layout;
	use Livewire\Volt\Component;
	
	new class extends Component {
		public string $email = '';
		
		/**
		 * Send a password reset link to the provided email address.
		 */
		public function sendPasswordResetLink() : void
		{
			$this->validate([
				'email' => ['required', 'string', 'email'],
			]);
			
			// We will send the password reset link to this user. Once we have attempted
			// to send the link, we will examine the response then see the message we
			// need to show to the user. Finally, we'll send out a proper response.
			$status = Password::sendResetLink(
				$this->only('email')
			);
			
			if ($status != Password::RESET_LINK_SENT) {
				$this->addError('email', __($status));
				
				return;
			}
			
			$this->reset('email');
			
			session()->flash('status', __($status));
		}
	}; ?>
<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
	<main class="flex h-full items-center">
		<main class="w-full max-w-md mx-auto p-6">
			<div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
				<div class="p-4 sm:p-7">
					<div class="text-center">
						<h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Forgot your password?</h1>
					</div>
					
					<p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
						{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
					</p>
					<hr class="my-5 border-slate-300">
					<!-- Session Status -->
					<x-auth-session-status class="mb-4" :status="session('status')" />
					
					<form wire:submit="sendPasswordResetLink">
						<!-- Email Address -->
						<div>
							<x-input-label for="email" :value="__('Email')" />
							<x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required
							              autofocus />
							<x-input-error :messages="$errors->get('email')" class="mt-2" />
						</div>
						
						<div class="flex items-center justify-end mt-4">
							<x-primary-button>
								{{ __('Email Password Reset Link') }}
							</x-primary-button>
						</div>
					</form>
				
				</div>
			</div>
		</main>
	</main>
</div>

