<div class="modal fade bs-example-modal-lg" tabindex="-1" id="infoModal" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Details for <span id="fullAddress"></span></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <img class="zillow-img" id="chart" src="">
                        <br>
                        <h5 class="text-center">View Projections</h5>
                        <div class="col-md-12 text-center" id="zpid" zpid="">
                            <button class="btn btn-success chartBtn" data-years="1year" type="button">1 Year</button>
                            <button class="btn btn-success chartBtn" data-years="5years" type="button">5 Year</button>
                            <button class="btn btn-success chartBtn" data-years="10years" type="button">10 Year</button>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <img class="zillow-img" id="mainImage" src="">
                        <div class="otherImages"></div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-success">Zestimate: $<span class="text-primary" id="zestimate"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-success">Zestimate Date: <span class="text-primary" id="ZestimateDate"></span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-success">Year Built: <span class="text-primary" id="built"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-success">Sq Feet: <span class="text-primary" id="sqft"></span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-success">Bedrooms: <span class="text-primary" id="bedrooms"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-success">Bathrooms: <span class="text-primary" id="bathrooms"></span></p>
                    </div>
                </div>
                <div class="row">
                    <h4>Extra Information (if availiable):</h4>
                    <div class="col-md-12" id="additionalInfo"></div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="link" class="btn btn-default" target="_blank" href="" >View on Zillow.com</a>
                <button type="button" id="closeModal" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
