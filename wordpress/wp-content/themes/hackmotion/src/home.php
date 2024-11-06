<main>
    <!-- Hero Section -->
    <section class="hero xl:w-[1163px] mx-auto min-h-[75vh] lg:min-h-[88.5vh] pb-4 px-4">
        <div class=" min-h-[75vh] lg:min-h-[71vh] grid lg:grid-cols-2">
            <div class="my-auto sm:pr-4">
                <h1 class="text-2xl/[31.2px] font-medium sm:text-[32px]/[41.6px] mb-6">We have put together a swing improvement solution to help you
                    <span class="text-primary-normal"> <?php echo isset($_GET['goal']) ? htmlspecialchars($_GET['goal']) : 'break 80'; ?></span>
                </h1>
                <span class="text-xl/[30px] sm:text-2xl/[36px]">
                    Pack includes:
                </span>
                <hr class="h-px my-2 bg-black/[7%] border-0">
                <div class="border-l-4  font-medium text-xl/[26px] sm:text-2xl/[31.2px] px-2 border-primary-normal">
                    <p> Swing Analyzer - HackMotion Core</p>
                    <p> Drills by coach Tyler Ferrell</p>
                    <p> Game improvement plan by HackMotion</p>
                </div>
                <button onclick="scrollToVideo();" class="bg-primary-normal  font-medium text-sm/[18px] mt-6 flex flex-row !p-3 sm:p-4 rounded-full items-center text-white">
                    Start Now <svg width="24" height="25" fill="none">
                        <mask id="a" width="24" height="25" x="0" y="0" maskUnits="userSpaceOnUse" style="mask-type:alpha">
                            <path fill="#D9D9D9" d="M0 .25h24v24H0z" />
                        </mask>
                        <g mask="url(#a)">
                            <path fill="#fff" d="M16.175 13.25H5a.967.967 0 0 1-.713-.287A.968.968 0 0 1 4 12.25c0-.283.096-.52.287-.713A.967.967 0 0 1 5 11.25h11.175l-4.9-4.9a.916.916 0 0 1-.287-.7c.008-.267.112-.5.312-.7.2-.183.433-.28.7-.288.267-.008.5.088.7.288l6.6 6.6c.1.1.17.208.212.325.042.117.063.242.063.375s-.02.258-.063.375a.877.877 0 0 1-.212.325l-6.6 6.6a.933.933 0 0 1-.688.275c-.274 0-.512-.092-.712-.275-.2-.2-.3-.438-.3-.713 0-.274.1-.512.3-.712l4.875-4.875Z" />
                        </g>
                    </svg>
                </button>
            </div>
            <div class="lg:max-w-[565px] mx-auto max-lg:mt-6">
                <img class="pb-4 mx-auto aspect-auto w-full" src="<?php echo get_template_directory_uri(); ?>/assets/images/Improvement Graph.png">
                <div class="grid sm:grid-cols-2 gap-4">
                    <img class="w-full aspect-auto" src="<?php echo get_template_directory_uri(); ?>/assets/images/Improvement Progress bar.png">
                    <img class="w-full aspect-auto" src="<?php echo get_template_directory_uri(); ?>/assets/images/Frame.png">
                </div>
            </div>
        </div>
    </section>

    <!-- Video Section -->
    <section class="video-section xl:w-[1163px] min-h-[85vh] pb-4 lg:min-h-[92vh] mx-auto max-sm:mt-8 px-4">
        <h2 class="text-primary-normal text-[32px]/[41.6px] font-medium sm:text-[48px]/[62.4px] ">The best solution for you: Impact Training Program</h2>
        <hr class="h-px my-8 bg-black/[7%] border-0">
        <div class="grid lg:grid-cols-3 pt-4">
            <video id="trainingVideo" class="lg:col-span-2 mx-auto max-w-[746px] aspect-auto" controls width="100%">
                <source class="video" src="<?php echo get_template_directory_uri(); ?>/assets/videos/Impact-Drill.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="flex lg:flex-row max-lg:flex-col">
                <div class="lg:mr-4 lg:flex-none max-lg:!w-full max-lg:mt-4 max-lg:h-2  lg:w-4 lg:h-full lg:ml-4 overflow-hidden bg-white rounded-full">
                    <div id="progress-bar" class="bg-primary-normal  rounded-full max-lg:ml-1.5 lg:mx-auto lg:mt-1 max-lg:!mt-0.5 max-lg:!h-1 max-lg:w-0 lg:!w-1"></div>
                </div>
                <div id="drills-container" class="video-controls flex flex-col max-lg:mt-4">
                    <?php
                    include get_template_directory() . '/src/components/video-text.php';
                    render_drill_component(5, "Static top drill", "Get a feel for the optimal wrist position at Top of your swing");
                    render_drill_component(14, "Dynamic top drill", "Get a feel for the optimal wrist position at Top of your swing 2");
                    render_drill_component(24, "Top full swing challenge", "Get a feel for the optimal wrist position at Top of your swing 3");
                    ?>
                </div>
            </div>
        </div>
    </section>
</main>