<div class="products-filter-panel">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div style="display: none;" class="btn-group pull-left hidden-xs">
                <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><i class="zmdi zmdi-apps"></i></button>
                <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="zmdi zmdi-view-list-alt"></i></button>
            </div>
            <div class="pull-right">
                <a href="<?php echo $compare; ?>" class="btn-link" id="compare-total"><?php echo $text_compare; ?></a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="pull-right">
                <div class="select-wrap">
                    <select id="input-sort" class="form-control" onchange="location = this.value;">
                        <?php foreach ($sorts as $sorts) { ?>
                        <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                        <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="group-text pull-right">
                <label class="control-label" for="input-sort"><?php echo $text_sort; ?></label>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="pull-right">
                <div class="select-wrap">
                    <select id="input-sort" class="form-control" onchange="location = this.value;">
                        <?php foreach ($categorys as $category) { ?>
                        <?php if ($category['value'] == $category_value) { ?>
                        <option value="<?php echo $category['href']; ?>" selected="selected"><?php echo $category['text']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $category['href']; ?>"><?php echo $category['text']; ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="group-text pull-right">
                <label class="control-label" for="input-sort"><?php echo $text_category; ?></label>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="pull-right">
                <div style="width: 90px;" class="select-wrap">
                    <select id="input-sort" class="form-control" onchange="location = this.value;">
                        <?php foreach ($brands as $brand) { ?>
                        <?php if ($brand['value'] == $brand_value) { ?>
                        <option value="<?php echo $brand['href']; ?>" selected="selected"><?php echo $brand['text']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $brand['href']; ?>"><?php echo $brand['text']; ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="group-text pull-right">
                <label class="control-label" for="input-sort"><?php echo $text_brand; ?></label>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="pull-right">
                <div style="width: 70px;" class="select-wrap">
                    <select id="input-limit" class="form-control" onchange="location = this.value;">
                        <?php foreach ($limits as $limits) { ?>
                        <?php if ($limits['value'] == $limit) { ?>
                        <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="group-text pull-right">
                <label class="control-label" for="input-limit"><?php echo $text_limit; ?></label>
            </div>
        </div>
    </div>
</div>