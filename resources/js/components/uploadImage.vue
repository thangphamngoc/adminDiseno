<template>
    <div>
        <div class="input-group-prepend">
            <p>Upload ảnh project <i>(768 x 432)</i></p>
          </div>
          <!-- <img src="url('storage/images/123.png')" alt="123" title="12" /> -->
          <div class="row">
            <div class="col-md-3" v-if="images != ''">
              <img
                :src="images"
                class="img-responsive"
                height="90%"
                width="90%"
              />
              <button
                type="button"
                class="btn btn-danger remove-button"
                @click="removeImage(key)"
                v-if="item != ''"
              >
                Remove
              </button>
            </div>
            <div class="col-md-6">
              <input
                type="file"
                id="files"
                v-on:change="onImageChange"
                class="form-control custom-file"
                ref="attachments"
                required
              />
            </div>
            <!-- <div class="col-md-3">
                  <button
                    class="btn btn-success btn-block"
                    @click="uploadImage"
                  >
                    Upload Image
                  </button>
                </div> -->
          </div>
    </div>
</template>

<script>
const config = {
  headers: { "content-type": "multipart/form-data" },
};
export default {
   data() {
        return {
        update: false,
        loadingButton: false,
        images: "",
        photos: "",
        }
    },
    method:{
        onImageChange() {
      // let files = e.target.files || e.dataTransfer.files;
      let files = this.$refs.attachments.files;
      // let files = e.target.files;
      // this.photos.push(e.target.files[0]);
      if (!files.length) return;

      for (let i = 0; i < files.length; i++) {
        this.photos = files[i];
        this.createImage(files[i]);
      }

      // for (let i = 0; i < files.length; i++) {
      //   let files = files[i];
      //   this.form.photos.push(files);
      //   this.createImage(files);
      // }
    },
    createImage(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = (e) => {
        vm.images = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    removeImage() {
      this.images = "";
      if (this.images == "") return;
    },
    }

}
</script>
