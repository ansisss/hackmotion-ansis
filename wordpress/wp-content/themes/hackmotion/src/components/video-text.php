<?php
defined('ABSPATH') || exit;

function render_drill_component($time, $title, $description)
{
?>
    <div class="drill-component" data-time="<?php echo intval($time); ?>">
        <button class="text-left text-xl/[26px] font-medium sm:text-2xl text-primary-normal flex flex-row items-center gap-2" onclick="seekTo(<?php echo intval($time); ?>)">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" class="chevron size-6" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>
            <?php echo esc_html($title); ?>
        </button>
        <p class="text-base sm:text-xl pt-2 hidden drill-description">
            <?php echo esc_html($description); ?>
        </p>
        <hr class="h-px my-2 bg-black/[7%] border-0">
    </div>
<?php
}
