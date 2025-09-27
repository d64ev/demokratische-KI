<?php

?>
<div
   
>
    <div class="">
        <!-- custom layout starts here -->
        <div>
    <div class="">
        <section id="primary">
            <main id="main" class="!max-w-4xl !m-auto">
                <div class="!flex !flex-row !items-center !w-full !justify-between xl:!pb-0 !pt-4 !px-4 md:!pb-4 md:!pt-12 lg:!pt-20">
                    <h1 class="!italic !font-medium !text-lg sm:!text-xl md:!text-2xl xl:!text-center">Veranstaltungen</h1>
                    <div class="!flex !gap-1 !ml-4">
                        <a href="?show_all=0" class="<?php echo !isset($_GET['show_all']) ? '!font-bold text-sm hover:bg-[#f2f0ed] p-1 rounded' : 'text-sm hover:bg-[#f2f0ed] p-1 rounded'; ?>">Kommende</a>
                        <a href="?show_all=1" class="<?php echo isset($_GET['show_all']) ? '!font-bold text-sm hover:bg-[#f2f0ed] p-1 rounded' : 'text-sm hover:bg-[#f2f0ed] p-1 rounded'; ?>">Alle</a>
                    </div>
                </div>
                <section id="events-preview" class="!py-6 !px-4 sm:!py-6 md:!py-8 lg:!py-10">
                    <?php
                    // Set up query args
                    $args = [
                        'posts_per_page' => 12,
                        'orderby' => ['event_date' => 'ASC']
                    ];

                    // If not showing all events, only show upcoming
                    if (!isset($_GET['show_all']) || !$_GET['show_all']) {
                        $args['start_date'] = 'now';
                    }

                    // Get events
                    $events = tribe_get_events($args);

                    // Ensure the global post variable is in scope
                    global $post;
                    
                    if (!empty($events)) { ?>
                        <div class="flex flex-col gap-4">
                            <?php foreach ($events as $post) : 
                                setup_postdata($post);
                                get_template_part('template-parts/components/event-tile');
                            endforeach; 
                            wp_reset_postdata(); ?>
                        </div>
                    <?php } else { ?>
                        <p class="!text-lg !font-medium !text-center">Aktuell sind keine Veranstaltungen geplant.</p>
                    <?php } ?>
                </section>
            </main>
        </section>
    </div>
</div>
        <!-- custom layout ends here -->
    </div>
</div>