<div class="animated-timeline-block py-16 bg-primary-50" data-laragrape-block="animated-timeline">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold mb-4 text-primary-900" data-gjs-type="text" data-gjs-name="timeline-title">Our Development Process</h2>
            <p class="text-lg text-primary-700" data-gjs-type="text" data-gjs-name="timeline-subtitle">A proven methodology that ensures successful project delivery</p>
        </div>

        <div class="relative">
            <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-primary-300"></div>
            <div class="space-y-12">
                @foreach([
                    ['title' => 'Discovery & Planning', 'duration' => '1-2 weeks', 'description' => 'We analyze your requirements and create a detailed project roadmap.'],
                    ['title' => 'Design & Prototyping', 'duration' => '2-3 weeks', 'description' => 'Our designers create wireframes and interactive prototypes for your approval.'],
                    ['title' => 'Development', 'duration' => '4-8 weeks', 'description' => 'Our development team builds your solution using modern technologies and best practices.'],
                    ['title' => 'Testing & QA', 'duration' => '1-2 weeks', 'description' => 'Comprehensive testing ensures your application is bug-free and performs optimally.'],
                    ['title' => 'Deployment & Launch', 'duration' => '1 week', 'description' => 'We deploy your application and provide ongoing support and maintenance.'],
                ] as $index => $step)
                    @php $n = $index + 1; $alignRight = $n % 2 === 0; @endphp
                    <div class="timeline-step relative {{ $alignRight ? 'right-0' : 'left-0' }}" data-gjs-type="default" data-gjs-droppable="false">
                        <div class="flex items-center {{ $alignRight ? 'flex-row-reverse' : 'flex-row' }}">
                            <div class="w-5/12 p-6 rounded-lg shadow-lg bg-primary-50 border-l-4 border-accent {{ $alignRight ? 'ml-8' : 'mr-8' }}">
                                <div class="flex items-center mb-3">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 bg-accent">
                                        <svg class="w-6 h-6 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-primary-900" data-gjs-type="text" data-gjs-name="timeline-title-{{ $n }}">{{ $step['title'] }}</h3>
                                        <span class="text-sm font-semibold text-accent" data-gjs-type="text" data-gjs-name="timeline-duration-{{ $n }}">{{ $step['duration'] }}</span>
                                    </div>
                                </div>
                                <p class="text-base text-primary-700" data-gjs-type="text" data-gjs-name="timeline-description-{{ $n }}">{{ $step['description'] }}</p>
                            </div>
                            <div class="relative z-10">
                                <div class="w-6 h-6 rounded-full bg-accent border-4 border-primary-50"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
