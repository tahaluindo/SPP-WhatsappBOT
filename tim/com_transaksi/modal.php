<!-- Modal -->
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Setoran Tunai</h4>
      </div>
      <div class="modal-body">

        <form action="?module=transaksi&aksi=setoran_tunai" class="form-horizontal form-label-left" method="POST">

          <div class="form-group">
            <div class="col-sm-12 col-sm-12 col-xs-12 ">
              <div class="input-group">
                <input type="text" class="typeahead form-control" placeholder="Tulis Nomor Rekening" required name="no_rekening" autofocus=”autofocus” autocomplete="off">
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Cari</button>
                </span>

              </div>

            </div>
          </div>
        </form>

      </div>

      <!-- end form for validations -->
    </div>
  </div>
</div>
<!-- /modal -->


<!-- Modal -->
<div class="modal fade" id="tarikAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Penarikan Tunai</h4>
      </div>
      <div class="modal-body">

        <form action="?module=transaksi&aksi=penarikan_tunai" class="form-horizontal form-label-left" method="POST">

          <div class="form-group">
            <div class="col-sm-12 ">
              <div class="input-group">
                <input type="text" class="typeahead form-control" placeholder="Tulis Nomor Rekening" required name="no_rekening" autofocus=”autofocus” autocomplete="off">
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-danger"><i class="fa fa-search"></i> Cari</button>
                </span>

              </div>

            </div>
          </div>
        </form>

      </div>

      <!-- end form for validations -->
    </div>
  </div>
</div>
<!-- /modal -->