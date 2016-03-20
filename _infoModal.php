<div class="modal fade bs-example-modal-lg" tabindex="-1" id="infoModal" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Details for <span id="fullAddress"></span></h4>
            </div>
            <div class="">
                <div class="col-md-12 text-center">
                    <img class="" id="chart" src="" class="zillow-img">
                </div>
                <br>
                <h5 class="text-center">View Projections</h5>
                <div class="col-md-12 text-center" id="zpid" zpid="">
                    <button class="btn btn-success chartBtn" data-years="1year" type="button">1 Year</button>
                    <button class="btn btn-success chartBtn" data-years="5year" type="button">5 Year</button>
                    <button class="btn btn-success chartBtn" data-years="10year" type="button">10 Year</button>
                </div>
            </div>
            <div class="">
                <div class="col-md-6">
                    <p class="text-success">Zestimate: $<span class="text-primary" id="zestimate"></span></p>
                </div>
                <div class="col-md-6">
                    <p class="text-success">Zestimate Date: <span class="text-primary" id="ZestimateDate"></span></p>
                </div>
            </div>
            <div class="">
                <div class="col-md-6">
                    <p class="text-success">Neighborhood: <span class="text-primary" id="area"></span></p>
                </div>
                <div class="col-md-6">
                    <p class="text-success">Neighborhood Avg Zestimate: <span class="text-primary" id="areaAvg"></span></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3 id="areaAvg"></h3>
                    <h3 id="chart"></h3>
                    <h3 id="fullDetails"></h3>
                    <h3 id="lat"></h3>
                    <h3 id="link"></h3>
                    <h3 id="lon"></h3>
                    <h3 id="zpid"></h3>
                </div>
            </div>
        </div>
    </div>
</div>