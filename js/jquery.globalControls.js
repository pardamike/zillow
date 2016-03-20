(function($) {
    $.fn.globalControls = function(config) {
        
        var obj = {
            //-- VARIABLES --///
            _checkItBtnID: "",
            _inputClasses: "",
            _chartBtnClass: "",
            // -- END VARIABLES -- // 



            // -- DOCUMENT READY ACTIONS -- //
            init:function(){
                obj.attachEvents();
            },
            // END DOCUMENT READY ACTIONS -- //



            // -- EVENTS HANDLERS (attached on document ready) -- //
            attachEvents:function() {
                $('#'+obj._checkItBtnID).on('click',function() {
                    obj.getAddress();
                });
                $('.'+obj._chartBtnClass).on('click',function() {
                    obj.loadChart($(this).parent($('#zpid')).attr('zpid'), $(this).data('years'));
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
                    if(key == 'chart') {
                        $('#'+key).attr('src',val);
                    } else if(key == 'zpid') {
                        $('#'+key).attr('zpid',val);
                    } else {
                        $('#'+key).html(val);
                    }
                    
                });
                $('#infoModal').modal('show');
            },
            loadChart:function(zpid, years) {
                var data = {"zpid": zpid, "years": years};
                console.log(data);
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
                            console.log(res);
                        } else {
                            alert(res.result);
                        }
                    }
                });
            }
           // END FUNCTIONS -- /
           
        };
        var new_object = $.extend({},obj,config);
        $.extend(obj,config);
        return new_object;
    };
}(jQuery));