<template>
  <div>
    <div class="input-group-prepend">
      <!-- <p>Upload ảnh project <i>(768 x 432)</i></p> -->
      <p>okok</p>
    </div>
    <!-- <img src="url('storage/images/123.png')" alt="123" title="12" /> -->
    <div class="row">
      <div class="col-md-3" v-if="images != ''">
        <div v-for="(img, key) in images" :key="key">
          <img :src="img" class="img-responsive" height="90%" width="90%" />
          <button
            type="button"
            class="btn btn-danger remove-button"
            @click="removeImage(key)"
            v-if="item != ''"
          >
            Remove
          </button>
        </div>
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
//   props: ["photos"],
  data() {
    return {
      update: false,
      loadingButton: false,
      images: "",
      photos: "",
    };
  },
  watch: {
    photos() {
      this.$emit("inputData", this.photos
      );
    },
  },
  method: {
    onImageChange() {
      alert("hi");
      let files = this.$refs.attachments.files;
      if (!files.length) return;
      for (let i = 0; i < files.length; i++) {
        this.photos.push(files[i]);
        console.log(this.photos);
        this.createImage(files[i]);
      }
    },
    createImage(file) {
      let reader = new FileReader();
      reader.onload = (e) => {
        this.images.push(e.target.result);
        console.log(this.images);
      };
      reader.readAsDataURL(file);
    },
    removeImage() {
      this.images = "";
      if (this.images == "") return;
    },
  },
};
</script>
