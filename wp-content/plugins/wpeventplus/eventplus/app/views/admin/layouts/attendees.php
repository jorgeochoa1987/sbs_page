<style>body{overflow-x: hidden;}</style>
<div class="events-plus_page_attendee">
    <div class="wrap">
        <h2><a href="#"><img src="<?php echo $this->assetUrl('images/evrplus_icon.png'); ?>" alt="Event Registration for Wordpress" /></a></h2>
        <h2><?php _e('Event Attendees Management', 'evrplus_language'); ?></h2>

        <?php if (!empty($oEvent) && is_object($oEvent)): ?>
            <?php if (isset($_GET['method']) == false): ?>
                <a href="<?php echo $this->adminUrl('admin_attendees/add', array('event_id' => $oEvent->id)); ?>" class="evrplus_button"><?php _e('Add Attendee', 'evrplus_language'); ?></a>

            <?php endif; ?>
            <a href="<?php echo $this->adminUrl('admin_events/edit', array('id' => $oEvent->id)); ?>" class="evrplus_button"><?php _e('Edit Event', 'evrplus_language'); ?></a>

            <?php if (isset($_GET['method'])): ?>

                <a href="<?php echo $this->adminUrl('admin_attendees', array('event_id' => $oEvent->id)); ?>" class="evrplus_button"><?php _e('Back to Attendees', 'evrplus_language'); ?></a>
            <?php endif; ?>

        <?php endif; ?>

        <a href="<?php echo $this->adminUrl('admin_events'); ?>" class="evrplus_button"><?php _e('View All Events', 'evrplus_language'); ?></a>


        <?php echo $content; ?>

    </div>
</div>
<div style='text-align: center;'>
    <?php echo EventPlus_Helpers_Funx::promoBanner(); ?>
</div>