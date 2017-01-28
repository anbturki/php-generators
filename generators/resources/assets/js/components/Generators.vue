<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component</div>

                    <div class="panel-body">
                        <table class="table">
						  <thead>
						    <tr>
						      <th>#</th>
						      <th>Name</th>
						      <th>Area</th>
						      <th>daily_use</th>
						    </tr>
						  </thead>
						  <tbody>
						  	<tr v-for="model in models">
						      <th scope="row">{{model.id}}</th>
						      <td>{{model.name}}</td>
						      <td>{{model.area}}</td>
						      <td>{{model.daily_use}}</td>
						    </tr>

						  </tbody>
						</table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
    	data() {
    		return {
    			models: []
    		}
    	},
        mounted() {
            this.$http.get('http://localhost:8000/api/generators').then(response => {
            	this.models = response.body.model.data;
            	console.log(this.models);
            })
        }
    }
</script>
