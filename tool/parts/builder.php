<div class="bpt-container">
    <div class="bpt-tabs">
        <div class="tab-item tab-1 active" data-tab="1">
            <span class="step-num">1</span>
            <span class="step-title">
                <span>Choose a Model</span>
            </span>
        </div>

        <div class="tab-item tab-2" data-tab="2">
            <span class="step-num">2</span>
            <span class="step-title">
                <span>Choose a Front Attachment</span>
            </span>
        </div>

        <div class="tab-item tab-3" data-tab="3">
            <span class="step-num">3</span>
            <span class="step-title">
                <span>Choose a Rear Attachment</span>
            </span>
        </div>

        <div class="tab-item tab-4" data-tab="4">
            <span class="step-num">4</span>
            <span class="step-title">
                <span>Choose an Upgrade</span>
            </span>
        </div>

        <div class="tab-item tab-5" data-tab="5">
            <span class="step-num">5</span>
            <span class="step-title">
                <span>Shipping & Discount</span>
            </span>
        </div>
    </div>
    <div class="bpt-tabs-content">
        <?php
        do_action('bpt-step-1');
        do_action('bpt-step-2');
        ?>
    </div>
</div>