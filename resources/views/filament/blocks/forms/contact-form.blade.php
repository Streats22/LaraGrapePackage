{{-- @block id="contact-form" label="Contact Form" description="A contact form with name, email, and message fields" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
    <div class="contact-form max-w-2xl mx-auto py-8 border-l-8 border-accent shadow-lg">
        <form class="bg-white shadow-lg rounded-lg p-8 border-2 border-accent">
            <h3 class="text-2xl font-extrabold mb-6 text-center text-primary-900">Contact Us</h3>
            <div class="mb-4">
                <label class="block text-primary-700 text-sm font-bold mb-2">Name</label>
                <input type="text" class="shadow appearance-none border-2 border-accent rounded w-full py-2 px-3 text-primary-900 leading-tight" placeholder="Your name" disabled>
            </div>
            <div class="mb-4">
                <label class="block text-primary-700 text-sm font-bold mb-2">Email</label>
                <input type="email" class="shadow appearance-none border-2 border-accent rounded w-full py-2 px-3 text-primary-900 leading-tight" placeholder="your@email.com" disabled>
            </div>
            <div class="mb-6">
                <label class="block text-primary-700 text-sm font-bold mb-2">Message</label>
                <textarea rows="4" class="shadow appearance-none border-2 border-accent rounded w-full py-2 px-3 text-primary-900 leading-tight" placeholder="Your message" disabled></textarea>
            </div>
            <div class="mb-6 flex items-center">
                <input type="checkbox" class="mr-2 accent-accent" disabled>
                <label class="text-primary-700 text-sm">I consent to having this website store my submitted information so they can respond to my inquiry.</label>
            </div>
            <div class="text-center">
                <button type="button" class="bg-accent text-primary-900 font-bold py-2 px-6 rounded shadow opacity-60 cursor-not-allowed" disabled>Send Message</button>
            </div>
        </form>
    </div>
@else
    <div class="contact-form max-w-2xl mx-auto py-8 border-l-8 border-accent shadow-lg">
        @if(session('success'))
            <div class="mb-6 p-4 bg-success/10 border-l-4 border-success text-success rounded shadow">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-6 p-4 bg-error/10 border-l-4 border-error text-error rounded shadow">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="bg-white shadow-lg rounded-lg p-8 border-2 border-accent" method="POST" action="{{ route('contact.submit') }}" novalidate>
            @csrf
            <h3 class="text-2xl font-extrabold mb-6 text-center text-primary-900" data-gjs-type="text" data-gjs-name="form-title">Contact Us</h3>
        <div class="mb-4">
                <label class="block text-primary-700 text-sm font-bold mb-2" for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="shadow appearance-none border-2 border-accent rounded w-full py-2 px-3 text-primary-900 leading-tight focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent @error('name') border-error ring-error @enderror" placeholder="Your name" required aria-required="true" aria-invalid="@error('name')true@enderror">
                @error('name')<span class="text-error text-xs mt-1 block">{{ $message }}</span>@enderror
        </div>
        <div class="mb-4">
                <label class="block text-primary-700 text-sm font-bold mb-2" for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="shadow appearance-none border-2 border-accent rounded w-full py-2 px-3 text-primary-900 leading-tight focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent @error('email') border-error ring-error @enderror" placeholder="your@email.com" required aria-required="true" aria-invalid="@error('email')true@enderror">
                @error('email')<span class="text-error text-xs mt-1 block">{{ $message }}</span>@enderror
        </div>
        <div class="mb-6">
                <label class="block text-primary-700 text-sm font-bold mb-2" for="message">Message</label>
                <textarea id="message" name="message" rows="4" class="shadow appearance-none border-2 border-accent rounded w-full py-2 px-3 text-primary-900 leading-tight focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent @error('message') border-error ring-error @enderror" placeholder="Your message" required aria-required="true" aria-invalid="@error('message')true@enderror">{{ old('message') }}</textarea>
                @error('message')<span class="text-error text-xs mt-1 block">{{ $message }}</span>@enderror
            </div>
            <!-- Consent Checkbox -->
            <div class="mb-6 flex items-center">
                <input type="checkbox" id="consent" name="consent" class="mr-2 accent-accent focus:ring-accent" {{ old('consent') ? 'checked' : '' }} required aria-required="true">
                <label for="consent" class="text-primary-700 text-sm">I consent to having this website store my submitted information so they can respond to my inquiry.</label>
                @error('consent')<span class="text-error text-xs ml-2">{{ $message }}</span>@enderror
            </div>
            <!-- Honeypot Field -->
            <div style="display:none">
                <label for="website">Website</label>
                <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
        </div>
        <div class="text-center">
                <button type="submit" class="bg-accent hover:bg-primary-700 text-primary-900 font-bold py-2 px-6 rounded focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 shadow transition-colors">Send Message</button>
        </div>
    </form>
</div> 
@endif 