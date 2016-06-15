<div class="populac-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
    <p>
        <?= date('Y-m-d H:i:s', 1464513648)?>
    </p>
    <p>
        <?= date('Y-m-d H:i:s', 1464410295)?>
    </p>
</div>
<?php \common\widgets\JsBlock::begin(); ?>
    <script type="text/javascript">
        $(function() {
            var date = new Date(1464409624*1000);
            console.log(date);
            var data = "1464409624";
            var dtStart = new Date(parseInt(data.substr(6)));
            var dtStartWrapper = moment(dtStart);
            console.log(dtStartWrapper.format('DD/MM/YYYY HH:mm')) ;
            console.log(moment(1464409624).format());

            var date = new Date(1464409624*1000);
// Hours part from the timestamp
            var hours = date.getHours();
// Minutes part from the timestamp
            var minutes = "0" + date.getMinutes();
// Seconds part from the timestamp
            var seconds = "0" + date.getSeconds();

// Will display time in 10:30:23 format
            var formattedTime = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
            console.log(formattedTime);
            //moment.locale('zh-cn');
            //;  // 几秒前
            console.log(moment(1464410295 * 1000).fromNow());
            console.log(moment(1464410295 * 1000).format('L LT'));
        });
    </script>
<?php \common\widgets\JsBlock::end(); ?>
