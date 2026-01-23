<form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal" id="content_admin" onsubmit=" return checkpass()" autocomplete="off" action="/ecommerce/artistjob/talentadmin/excelimport">
	<div style="display:none;"><input type="hidden" name="_method" value="POST"></div>
	<div class="box-body">



		<div class="form-group">
			<label class="col-sm-3 control-label">CSV File Upload
			</label>
			<div class="field col-sm-6">
				<input class="input-file" id="file" type="file" name="file" onchange="return fileValidation()">
				<label tabindex="0" for="my-file" class="input-file-trigger">Upload Excel File</label>
			</div>
		</div>







		<div class="form-group">
			<div class="col-sm-12 text-center">
				<div class="submit"><input type="submit" class="btn btn-primary" title="Submit" value="Submit"></div>
			</div>
		</div>
	</div>

	<!--content-->


	<!-- /.form group -->
</form>