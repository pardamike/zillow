(function($) {
    $.fn.globalControls = function(config) {
        
        var obj = {
            //-- VARIABLES --///
            _checkItBtnID: "",
            _inputClasses: "",
            _chartBtnClass: "",
            _chartID: "",
            _mainImageID: "",
            _smImageContainerClass: "",
            _smImgClass: "",
            _defaultImg: "",
            _additionalInfoContainer: "",
            _closeModalBtnID: "",
            _modalID: "",
            // -- END VARIABLES -- // 



            // -- DOCUMENT READY ACTIONS -- //
            init:function(){
                obj.attachEvents();
            },
            // END DOCUMENT READY ACTIONS -- //



            // -- EVENTS HANDLERS (attached on document ready) -- //
            attachEvents:function() {
                $(document).on('click', '#'+obj._checkItBtnID, function() {
                    obj.getAddress();
                });
                $(document).on('click', '.'+obj._chartBtnClass ,function() {
                    obj.loadChart($(this).parent($('#zpid')).attr('zpid'), $(this).data('years'));
                });
                $(document).on('click', '.'+obj._smImgClass, function() {
                    obj.replaceMainImg($(this).attr('src'));
                });
                $('#'+obj._modalID).on('hidden.bs.modal', function (e) {
                    obj.clearModal();
                });
            },
            // -- END EVENT HANDLERS -- //
            


            // -- FUNCTIONS -- //
            getAddress:function() {
                var addressInfo = {};
                $('.'+obj._inputClasses).each(function() {
                    addressInfo[$(this).attr('name')] = $(this).val();
                });
                obj.zillowFindAddress(addressInfo);
            },
            zillowFindAddress:function(addressInfo) {
                $.ajax({
                    url: "AjaxFunctions.php",
                    cache: false,
                    type:"POST",
                    data: {"data" : addressInfo, "action" : "findZPID"},        
                    error: function() {
                        alert('An error has occured :(');
                    },
                    success: function(ajaxresult) {
                        var res = $.parseJSON(ajaxresult);
                        if(res.result == "success") {
                            obj.populateModal(res);
                        } else {
                            alert(res.result);
                        }
                    }
                });
            },
            populateModal:function(info) {
                console.log(info);
                $.each(info, function(key, val) {
                    switch (key) {
                        case 'chart':
                            $('#'+key).attr('src',val);     
                            break;
                        case 'zpid':
                            $('#'+key).attr('zpid',val);
                            break;
                        case 'link':
                            $('#'+key).attr('href',val);
                            break;
                        case 'images':
                            if(val !== false) {
                                obj.loadImages($(this));
                            } else {
                                // No image, load the default placeholder
                                $('#'+obj._mainImageID).attr('src',obj._defaultImg);
                            }
                            break;
                        case 'fullDetails':
                            if(val !== false) {
                                obj.fillInDetails($(this));
                            } else {
                                $('#'+obj._additionalInfoContainer).html('<h4 class="text-muted"><b>No additional details are availible on this property...</b></h4>');
                            }
                            break;
                        default:
                            $('#'+key).html(val);
                            break;    
                    }        
                });
                $('#'+obj._modalID).modal('show');
            },
            loadChart:function(zpid, years) {
                var data = {"zpid": zpid, "years": years};
                $.ajax({
                    url: "AjaxFunctions.php",
                    cache: false,
                    type:"POST",
                    data: {"data" : data, "action" : "chart"},        
                    error: function() {
                        alert('An error has occured :(');
                    },
                    success: function(ajaxresult) {
                        var res = $.parseJSON(ajaxresult);
                        if(res.result == "success") {
                            $('#'+obj._chartID).attr('src', res.chartURL);
                        } else {
                            alert(res.result);
                        }
                    }
                });
            },
            // For the sake of brevity we are only going to load 3 images, you will have all of them availible in this array however
            loadImages:function(imgArr) {
                if(imgArr.length > 0) {
                    // Just going to do the first 3...you could do a foreach and use them all
                    for(var i = 0; i <= 2; i++) {
                        if(i == 0) {
                            $('#'+obj._mainImageID).attr('src',imgArr[i]);
                        }
                        $('.'+obj._smImageContainerClass).prepend('<img class="smImg" src="'+imgArr[i]+'" />');
                    }
                } else {
                    
                }
            },
            replaceMainImg:function(newSrc) {
                $('#'+obj._mainImageID).attr('src',newSrc);
            },
            // Lets throw in some extra stuff...
            fillInDetails:function($details) {
                var $info = $details[0];
                if($info.rooms) {
                    $('#'+obj._additionalInfoContainer).prepend('<p class="text-success">Rooms: <span class="text-primary">'+$info.rooms+'</span></p>');
                }
                if($info.appliances) {
                    $('#'+obj._additionalInfoContainer).prepend('<p class="text-success">Appliances: <span class="text-primary">'+$info.appliances+'</span></p>');
                }
                if($info.floorCovering) {
                    $('#'+obj._additionalInfoContainer).prepend('<p class="text-success">Flooring Materials: <span class="text-primary">'+$info.floorCovering+'</span></p>');
                }
                if($info.numFloors) {
                    $('#'+obj._additionalInfoContainer).prepend('<p class="text-success">Floors Number: <span class="text-primary">'+$info.numFloors+'</span></p>');
                }
            },
            clearModal:function() {
                $('#'+obj._additionalInfoContainer).html('');
                $('.'+obj._smImageContainerClass).html('');
            }
           // END FUNCTIONS -- /
           
        };
        var new_object = $.extend({},obj,config);
        $.extend(obj,config);
        return new_object;
    };
}(jQuery));