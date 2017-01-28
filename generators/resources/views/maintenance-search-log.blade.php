					<div class="generators-table">
					    <div class="table-responsive">
					    	<table class="table table-hover table-striped">
					    		<thead>
					    			<tr>
					    				<th>Date</th>
					    				<th>Details</th>
					    				<th>Display</th>
				    				</tr>
					    		</thead>
					    		<tbody>
					    			@foreach($maintenances as $m)
					    			<tr class="text-center">
					    				<td>{{$m->created_at->toDateString()}}</td>
					    				<td>
					    					@if($m->description)
												{{str_limit($m->description,25)}}
					    					@else
					    						<p class="label label-primary">There are no details</p>
					    					@endif
					    				</td>
										<td><a href="{{route('maintenances.show',$m->id)}}" class="modal-btn btn btn-info">Display</a></td>

					    			</tr>
					    			@endforeach
					    		</tbody>
					    	</table>
					    </div>
					</div>
