{{-- @block id="contact-form" label="Contact Form" description="A contact form with name, email, and message fields" --}}
<div class="contact-form max-w-2xl mx-auto py-8">
    <form class="bg-white shadow-lg rounded-lg p-8">
        <h3 class="text-2xl font-bold mb-6 text-center" data-gjs-type="text" data-gjs-name="form-title">Contact Us</h3>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
            <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Your name">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
            <input type="email" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="your@email.com">
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="message">Message</label>
            <textarea id="message" name="message" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Your message"></textarea>
        </div>
        
        <div class="text-center">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Send Message</button>
        </div>
    </form>
</div> 