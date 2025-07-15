{{-- @block id="list" label="List Block" description="A styled list block for bullet points or numbered lists" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="list-block py-12 md:py-16 bg-primary-50 dark:bg-primary-900 rounded-xl shadow-lg border-l-8 border-accent">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <h3 class="text-3xl font-extrabold mb-8 text-center text-primary-900 dark:text-primary-100 tracking-tight">Feature List</h3>
            <ul class="space-y-6">
                <li class="flex items-start bg-primary-50 dark:bg-primary-900 rounded-lg shadow p-4">
                    <div class="flex-shrink-0 w-8 h-8 bg-accent rounded-full flex items-center justify-center mr-4 mt-1 shadow-md">
                        <svg class="w-5 h-5 text-primary-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="text-lg text-primary-800 dark:text-primary-100 font-semibold">First feature or benefit of your product or service</span>
                </li>
                <li class="flex items-start bg-primary-50 dark:bg-primary-900 rounded-lg shadow p-4">
                    <div class="flex-shrink-0 w-8 h-8 bg-secondary rounded-full flex items-center justify-center mr-4 mt-1 shadow-md">
                        <svg class="w-5 h-5 text-primary-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="text-lg text-primary-800 dark:text-primary-100 font-semibold">Second feature or benefit of your product or service</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@else
<div class="list-block py-12 md:py-16 bg-primary-50 dark:bg-primary-900 rounded-xl shadow-lg border-l-8 border-accent">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <h3 class="text-3xl font-extrabold mb-8 text-center text-primary-900 dark:text-primary-100 tracking-tight" data-gjs-type="text" data-gjs-name="list-title">Feature List</h3>
            <ul class="space-y-6">
                <li class="flex items-start bg-primary-50 dark:bg-primary-900 rounded-lg shadow p-4 hover:bg-primary-100 dark:hover:bg-primary-800 transition">
                    <div class="flex-shrink-0 w-8 h-8 bg-accent rounded-full flex items-center justify-center mr-4 mt-1 shadow-md">
                        <svg class="w-5 h-5 text-primary-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="text-lg text-primary-800 dark:text-primary-100 font-semibold" data-gjs-type="text" data-gjs-name="list-item-1">First feature or benefit of your product or service</span>
                </li>
                <li class="flex items-start bg-primary-50 dark:bg-primary-900 rounded-lg shadow p-4 hover:bg-secondary/10 dark:hover:bg-primary-800 transition">
                    <div class="flex-shrink-0 w-8 h-8 bg-secondary rounded-full flex items-center justify-center mr-4 mt-1 shadow-md">
                        <svg class="w-5 h-5 text-primary-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="text-lg text-primary-800 dark:text-primary-100 font-semibold" data-gjs-type="text" data-gjs-name="list-item-2">Second feature or benefit of your product or service</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endif 