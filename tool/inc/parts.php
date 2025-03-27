<?php

namespace GO_BPT;

trait GO_BPT_Parts
{

    /**
     * Register template parts
     * @return void
     */
    public function register_template_parts()
    {
        add_action(
            'bpt-step-1',
            [$this, 'step_1']
        );
    }


    /**
     * Step 1
     * @return void
     */
    public function step_1()
    {
        include(GROWTH_OPTIMIZER_BPT_DIR.'tool/steps/step-1.php');
    }
}