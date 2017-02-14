/**
 * Created by Administrator on 2016/11/10.
 */
/*
 * 地址联动选择
 * input不为空时出现编辑按钮，点击按钮进行联动选择
 *
 * 使用范例：
 * [html]
 * <input id="region" name="region" type="hidden" value="" >
 * [javascrpt]
 * $("#region").nc_region();
 *
 */
(function($) {
    $.fn.nc_region = function(options) {
        var $region = $(this);
        var settings = $.extend({}, {area_id: 0, region_span_class: "_region_value"}, options);

        return this.each(function() {
            var $inputArea = $(this);
            if($inputArea.val() === '') {
                initArea($inputArea);
            } else {
                var $region_span = $('<span class="' + settings.region_span_class + '">' + $inputArea.val() + '</span>');
                var $region_btn = $('<input type="button"  value="编辑" />');
                $inputArea.after($region_span);
                $region_span.after($region_btn);
                $region_btn.on("click", function() {
                    $region_span.hide();
                    $region_btn.hide();
                    initArea($inputArea);
                });
            }
        });

        function initArea($inputArea) {
            settings.$area = $('<select></select>');
            $inputArea.after(settings.$area);
            loadAreaArray(function() {
                loadArea(settings.$area, settings.area_id);
            });
        }

        function loadArea($area, area_id){
            if($area && nc_a[area_id].length > 0){
                var areas = [];
                areas = nc_a[area_id];
                $area.append("<option>-请选择-</option>");
                for (i = 0; i <areas.length; i++){
                    $area.append("<option value='" + areas[i][0] + "'>" + areas[i][1] + "</option>");
                }
            }

            $area.on('change', function() {
                $(this).nextAll("select").remove();

                var region_value = '';
                $region.nextAll("select").each(function() {
                    region_value += $(this).find("option:selected").text() + ' ';
                });
                $region.val(region_value);

                var area_id = $(this).val();
                if(area_id > 0) {
                    if(nc_a[area_id] && nc_a[area_id].length > 0) {
                        var $newArea = $('<select></select>');
                        $(this).after($newArea);
                        loadArea($newArea, area_id);
                    }
                }
            });
        }

        function loadAreaArray(callback) {
            if(typeof nc_a === 'undefined') {
                //取JS目录的地址
                var area_scripts_src = '../js/areaselect/area_array.js';
              /*  area_scripts_src = $("script[src*='jquery.js']").attr("src");
                area_scripts_src = area_scripts_src.replace('jquery.js', 'area_array.js');*/
                $.ajax({
                    url: area_scripts_src,
                    async: false,
                    dataType: "script"
                }).done(function(){
                    callback();
                });
            } else {
                callback();
            }
        }
    };
})(jQuery);
