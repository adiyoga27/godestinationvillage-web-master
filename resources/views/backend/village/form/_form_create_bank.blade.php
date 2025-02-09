<div class="form-group row">
  <label class="col-sm-3 col-form-label">Nomor Rekening (*)</label>
  <div class="col-sm-9">
    {!! Form::text('bank_acc_no', null, ['class'=>'form-control', 'required'=>'required']) !!}
    {!! $errors->first('bank_acc_no', '<p class="text-danger">:message</p>') !!}
  </div>
</div>

<div class="form-group row">
  <label class="col-sm-3 col-form-label">Nama Bank (*)</label>
  <div class="col-sm-9">
    {!! Form::text('bank_name', null, ['class'=>'form-control', 'required'=>'required']) !!}
  {!! $errors->first('bank_name', '<p class="text-danger">:message</p>') !!}
  </div>
</div>

<div class="form-group row">
  <label class="col-sm-3 col-form-label">Nama Pemilik (*)</label>
  <div class="col-sm-9">
    {!! Form::text('bank_acc_name', null, ['class'=>'form-control', 'required'=>'required']) !!}
    {!! $errors->first('bank_acc_name', '<p class="text-danger">:message</p>') !!}
  </div>
</div>