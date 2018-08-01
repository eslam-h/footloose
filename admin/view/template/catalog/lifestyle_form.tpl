<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-lifestyle" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-lifestyle" class="form-horizontal">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-image" data-toggle="tab"><?php echo $tab_pictures; ?></a></li>
                        <li><a href="#tab-video" data-toggle="tab"><?php echo $tab_videos; ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-image">
                            <div class="table-responsive">
                                <table id="images" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <td class="text-left"><?php echo $entry_image; ?></td>
                                        <td class="text-right"><?php echo $entry_sort_order; ?></td>
                                        <td></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $image_row = 0; ?>
                                    <?php foreach ($gallery_images as $gallery_image) { ?>
                                    <tr id="image-row<?php echo $image_row; ?>">
                                        <td class="text-left"><a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $gallery_image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="gallery_image[<?php echo $image_row; ?>][image]" value="<?php echo $gallery_image['image']; ?>" id="input-image<?php echo $image_row; ?>" /></td>
                                        <td class="text-right"><input type="text" name="gallery_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $gallery_image['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
                                        <td class="text-left"><button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                    </tr>
                                    <?php $image_row++; ?>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $button_image_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-video">
                            <div class="table-responsive">
                                <table id="videos" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <td class="text-left"><?php echo $entry_video; ?></td>
                                        <td class="text-right"><?php echo $entry_sort_order; ?></td>
                                        <td></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $video_row = 0; ?>
                                    <?php foreach ($gallery_videos as $gallery_video) { ?>
                                    <tr id="video-row<?php echo $video_row; ?>">
                                        <td class="text-left"><input type="text" name="gallery_video[<?php echo $video_row; ?>][video]" value="<?php echo $gallery_video['link']; ?>" placeholder="<?php echo $entry_video_url; ?>" class="form-control" /></td>
                                        <td class="text-right"><input type="text" name="gallery_video[<?php echo $video_row; ?>][sort_order]" value="<?php echo $gallery_video['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
                                        <td class="text-left"><button type="button" onclick="$('#video-row<?php echo $video_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                    </tr>
                                    <?php $video_row++; ?>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td class="text-left"><button type="button" onclick="addvideo();" data-toggle="tooltip" title="<?php echo $button_video_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript"><!--

        var image_row = <?php echo $image_row; ?>;

        function addImage() {
            html  = '<tr id="image-row' + image_row + '">';
            html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="gallery_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
            html += '  <td class="text-right"><input type="text" name="galery_image[' + image_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
            html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';

            $('#images tbody').append(html);

            image_row++;
        }
        //--></script>

    <script type="text/javascript"><!--

        var video_row = <?php echo $video_row; ?>;

        function addvideo() {
            html  = '<tr id="video-row' + video_row + '">';
            html += '  <td class="text-left"><input type="text" name="gallery_video[' + video_row + '][video]" value="" placeholder="<?php echo $entry_video_url; ?>" class="form-control" /></td>';
            html += '  <td class="text-right"><input type="text" name="galery_video[' + video_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
            html += '  <td class="text-left"><button type="button" onclick="$(\'#video-row' + video_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';

            $('#videos tbody').append(html);

            video_row++;
        }
        //--></script>


<?php echo $footer; ?>