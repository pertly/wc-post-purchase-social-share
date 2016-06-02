<?php
defined( 'ABSPATH' ) or die();



$arrItems = array();
$orderItems = $order->get_items();
$options = array();
$i = 0;
if(!empty($orderItems)){
    foreach($orderItems as $oi){
        //$pid = !empty($oi['variation_id'])?$oi['variation_id']:$oi['product_id'];
        $pid = $oi['product_id'];
        $productDetails = get_post($pid);
        $ptid = get_post_thumbnail_id( $pid );
        $img = plugins_url('assets/photo-camera.jpg',(__FILE__));
        if(!empty($ptid)){
            $imgar = wp_get_attachment_image_src($ptid, 'thumbnail');
            $img = !empty($imgar['0'])?$imgar['0']:$img;
        }
        //$custom_fields = get_post_custom($pid);
        $desc = get_post_meta($pid, 'sf_product_description', true);
        if(empty($desc)){
            $desc = get_post_meta($pid, 'sf_product_short_description', true);
        }
        if(empty($desc)){
            $desc = $productDetails->post_excerpt;
        }
        if(empty($desc)){
            $desc = $productDetails->post_content;
        }
        $desc = strip_tags($desc);

        $pd = array(
            'title'=>'I just bought: "'.$productDetails->post_title.'"',
            'ori_title'=>$productDetails->post_title,
            'desc'=>urlencode(substr($desc, 0, 500)),
            'image'=>$img,
            'url'=>get_permalink($pid),
        );
        $options[] = '<option value="'.$i.'">'.$productDetails->post_title.'</option>';
        $arrItems[] = $pd;
        $i++;
    }
?>

<div id="wc-pp-ss-box-data" style="display: none"><?php echo json_encode($arrItems); ?></div>

<div id="wc-pp-ss-box-holder" class="tabs">
    <div class="sp-hdr-ss-tm">Share this purchase with your social network.</div>
    <ul>
        <li><a href="#tab-ss-fb"> <img class="wcpp-ss-icn-fb" src="<?php echo plugins_url('assets/facebook.png',(__FILE__)); ?>" /> Facebook</a></li>
        <li><a href="#tab-ss-tw"><img class="wcpp-ss-icn-twt" src="<?php echo plugins_url('assets/twitter.png',(__FILE__)); ?>" /> Twitter</a></li>
    </ul>
    <div id="tab-ss-fb">
        <div class="wc-pp-ss-s-holder">
            <div class="wc-pp-ss-s-img">
                <img src="<?php echo $arrItems['0']['image']; ?>" alt="<?php echo $arrItems['0']['ori_title']; ?>" />
            </div>
            <div class="wc-pp-ss-s-desc">
                <div class="wc-pp-ss-s-desc-ttl"><?php echo $arrItems['0']['title']; ?></div>
                <?php if(count($options)>1){ ?><div class="wc-pp-ss-s-desc-chng" onclick="wcPPSS.clickChangeFn(this)">Change product</div><?php } ?>
                <div class="wc-pp-ss-s-desc-chng-opts" style="display: none"><select onchange="wcPPSS.changeOptFn(this)"><option value="-1">Select</option><?php  echo implode('', $options); ?></select></div>
                <div class="wc-pp-ss-s-desc-txt"><?php echo urldecode($arrItems['0']['desc']); ?></div>
                <div class="wc-pp-ss-s-desc-btn wc-pp-ss-s-desc-btn-fbk"><a target="_blank" class="ss-temp-btn-shr" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $arrItems['0']['url']; ?>">Share in facebook</a></div>
            </div>
        </div>
    </div>
    <div id="tab-ss-tw" style="display: none">
        <div class="wc-pp-ss-s-holder">
            <div class="wc-pp-ss-s-img">
                <img src="<?php echo $arrItems['0']['image']; ?>" alt="<?php echo $arrItems['0']['ori_title']; ?>" />
            </div>
            <div class="wc-pp-ss-s-desc">
                <div class="wc-pp-ss-s-desc-ttl"><?php echo $arrItems['0']['title']; ?></div>
                <?php if(count($options)>1){ ?><div class="wc-pp-ss-s-desc-chng" onclick="wcPPSS.clickChangeFn(this)">Change product</div><?php } ?>
                <div class="wc-pp-ss-s-desc-chng-opts" style="display: none"><select onchange="wcPPSS.changeOptFn(this)"><option value="-1">Select</option><?php  echo implode('', $options); ?></select></div>
                <div class="wc-pp-ss-s-desc-txt"><?php echo urldecode($arrItems['0']['desc']); ?></div>
                <div class="wc-pp-ss-s-desc-btn wc-pp-ss-s-desc-btn-twt"><a target="_blank" class="ss-temp-btn-shr" href="https://twitter.com/share?text=<?php echo urlencode($arrItems['0']['title']); ?>&url=<?php echo $arrItems['0']['url']; ?>">Share in twitter</a></div>
            </div>
        </div>
    </div>
</div>

<?php } ?>