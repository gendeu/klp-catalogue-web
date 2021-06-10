<template>
    <div>
        <h3 class="text-center">Edit Product</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateProduct">
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
                            <input type="file" name="filename" class="custom-file-input" id="editFileUpload"
                                   v-on:change="onFileChange">
                            <label class="custom-file-label" for="editFileUpload">Choose file</label>
                        </div>
                    </div>
                    <img v-if="url" :src="url" style="width: 100px; height: 100px;"/>
                    <p class="text-success font-weight-bold">{{ filename }}</p>
                    <button type="submit" class="btn btn-primary">Update</button>
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
                values: [],
                url: '',
                filename: ''
            }
        },
        created() {
            this.axios
                .get(`http://localhost:8000/api/products/${this.$route.params.id}`)
                .then((res) => {
                    this.product = res.data;
                    this.filename = this.product.file_name;
                    this.url = '../' + this.product.file_path;
                });
        },
        methods: {
            onFileChange(e) {
                this.filename = e.target.files[0].name;
                this.file = e.target.files[0];
                this.url = URL.createObjectURL(this.file);
            },
            updateProduct() {
                
                let formData = new FormData();
                
                formData.append("picture", this.file);
                formData.append("filename", this.filename);
                formData.append("name", this.product.name);
                formData.append("detail", this.product.detail);
                
                this.axios
                    .patch(`http://localhost:8000/api/products/${this.$route.params.id}`, this.product)
                    .then((res) => {
                        // this.$router.push({ name: 'home' });
                        console.log(res.data);
                    });
            }
        }
    }
</script>