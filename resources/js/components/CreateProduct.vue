<template>
    <div>
        <h3 class="text-center">Create Product</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addProduct" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="product.name">
                    </div>
                    <div class="form-group">
                        <label>Detail</label>
                        <input type="text" class="form-control" v-model="product.detail">
                    </div>
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" name="filename" class="custom-file-input" id="inputFileUpload"
                                   v-on:change="onFileChange">
                            <label class="custom-file-label" for="inputFileUpload">Choose file</label>
                        </div>
                    </div>
                    <img v-if="url" :src="url" style="width: 100px; height: 100px;"/>
                    <p class="text-success font-weight-bold">{{ filename }}</p>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                product: {},
                filename: '',
                file: '',
                success: '',
                url: '',
            }
        },
        methods: {
            onFileChange(e) {
                this.filename = e.target.files[0].name;
                this.file = e.target.files[0];
                this.url = URL.createObjectURL(this.file);
            },
            addProduct() {

                let formData = new FormData();
                
                formData.append("picture", this.file);
                formData.append("filename", this.filename);
                formData.append("name", this.product.name)
                formData.append("detail", this.product.detail)
                
                this.axios
                    .post('http://localhost:8000/api/products', formData)
                    .then(response => (
                        this.$router.push({ name: 'home' })
                        // console.log(response.data)
                    ))
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            },

        }
    }
</script>