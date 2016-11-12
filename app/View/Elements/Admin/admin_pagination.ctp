<?php	
if($this->Paginator->params['paging'][$paging_model_name]['pageCount'] >= 2){ ?>
	<div class="row">
		<div class="col-lg-12">
			<section class="panels" style="padding:0px 10px; border-top:1px solid rgb(219, 224, 226);">
				<div class="dataTables_paginate paging_bootstrap pagination" style="float:right;"><?php						
					echo $this->Paginator->first('&laquo; First', array('title' => 'First Page','escape' => false));
					echo $this->Paginator->prev('&laquo; Previous', array('title' => 'Previous Page','escape' => false));
					echo $this->Paginator->numbers(array('class'=>'',  'separator'=>false));			           
					echo $this->Paginator->next('Next &raquo;', array('title' => 'Next Page','escape' => false));
					echo $this->Paginator->last('Last &raquo;', array('title' => 'Last Page','escape' => false)); ?>					
				</div>
			</section>
		</div>
	</div><?php
}