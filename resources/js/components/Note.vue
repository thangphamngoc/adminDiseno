<template>
  <div>
    <div class="input-group-prepend" v-if="update == true">
      <p>Upload Avatar</p>
    </div>
    <!-- <img src="url('storage/images/123.png')" alt="123" title="12" /> -->
    <div class="row" v-if="update == true">
      <div class="col-md-3" v-if="images != ''">
        <img :src="images" class="img-responsive" height="90%" width="90%" />
        <button
          type="button"
          class="btn btn-danger remove-button"
          @click="removeImage()"
          v-if="images != ''"
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
          :limit="5"
          ref="attachments"
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

    <div class="row" v-if="!update">
      <div class="col-md-3" v-for="(item, key) in images" :key="key">
        <img
          v-if="item != ''"
          :src="item"
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
          :limit="5"
          multiple
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
export default {
  submitForm() {
    let formDatas = new FormData();
    if (this.images != "") {
      formDatas.append("avatar", this.images);
    }
    for (var key in this.dataCreate) {
      formDatas.append(key, this.dataCreate[key]);
    }
    axios
      .post("/api/ctv/add", formDatas, config)
      .then((resp) => {
        this.handleBackdropClick();
        Swal.fire({
          icon: "success",
          title: "Lưu thành công",
          showConfirmButton: false,
          timer: 1500,
        });
      })
      .catch((err) => {
        Swal.fire({
          icon: "error",
          title: "Lưu thất bại",
          showConfirmButton: false,
          timer: 1500,
        });
      });
  },
  submitFormMulti() {
    let formDatas = new FormData();

    for (var i = 0; i < this.photos.length; i++) {
      let file = this.photos[i];
      formDatas.append("photos[" + i + "]", file);
    }
    for (var key in this.dataCreate) {
      formDatas.append(key, this.dataCreate[key]);
    }
    axios
      .post("/api/nick/add", formDatas, config)
      .then((resp) => {
        this.handleBackdropClick();
        Swal.fire({
          icon: "success",
          title: "Lưu thành công",
          showConfirmButton: false,
          timer: 1500,
        });
      })
      .catch((err) => {
        Swal.fire({
          icon: "error",
          title: "Lưu thất bại",
          showConfirmButton: false,
          timer: 1500,
        });
      });
  },
  // multi
  onImageChange() {
    // let files = e.target.files || e.dataTransfer.files;
    let files = this.$refs.attachments.files;
    // let files = e.target.files;
    // this.photos.push(e.target.files[0]);
    if (!files.length) return;

    for (let i = 0; i < files.length; i++) {
      this.photos.push(files[i]);
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
      vm.images.push(e.target.result);
    };
    reader.readAsDataURL(file);
  },
  removeImage: function (key) {
    this.images.splice(key, 1);
    if (this.images.length == 0) return;
  },

  //end Multi

  //oneimg
  onImageChange(e) {
    let files = e.target.files || e.dataTransfer.files;
    if (!files.length) return;
    this.dataCreate.avatar = files[0];
    this.createImage(files[0]);
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
};

//endoneimg
</script>