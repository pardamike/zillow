        <footer>
            <div class="container">
                <br>
                <div class="row">
                    <div class="col-md-12 text-center">
                        Thanks to Zillow for their API.  Check their web service API out <a class="btn btn-sm btn-warning" target="_blank" href="http://www.zillow.com/howto/api/APIOverview.htm">here</a>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a href="https://pardamike.github.io/" class="btn btn-primary"><i class="fa fa-question-circle"></i> About Me</a>
                        <a href="https://github.com/pardamike/zillow" class="btn btn-primary"><i class="fa fa-github"></i> View on Github</a>
                    </div>
                </div>
            </div>
            <br>
        </footer>
        <!-- jQuery -->
        <script src="jquery/dist/jquery.min.js" type="text/javascript"></script>

        <!-- Bootstraps JS -->
        <script src="bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
        
        <!-- jQuery BlockUI functions -->
        <script src="js/jquery.BlockUI.js" type="text/javascript"></script>

        <!-- Custom jQuery functions -->
        <script src="js/jquery.globalControls.js" type="text/javascript"></script>


        <script>
        var globalControls = $.fn.globalControls({
            _checkItBtnID: "checkIt",
            _inputClasses: "addressField",
            _chartBtnClass: "chartBtn",
            _chartID: "chart",
            _mainImageID: "mainImage",
            _smImageContainerClass: "otherImages",
            _smImgClass: "smImg",
            _defaultImg: "img/noImg.jpg",
            _additionalInfoContainer: "additionalInfo",
            _closeModalBtnID: "closeModal",
            _modalID: "infoModal"
        });
        globalControls.init();  
        $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
        </script>
</body>
	
</html>