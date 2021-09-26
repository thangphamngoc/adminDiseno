<template>
  <transition name="dialog">
    <div v-if="active" class="dialog-backdrop">
      <div class="dialog-container" @click.stop>
        <div class="d-flex justify-content-between">
          <h3>Thêm mới Banner Home</h3>
          <button
            type="button"
            class="btn btn-danger"
            @click="handleBackdropClick"
          >
            Close
          </button>
        </div>
        <hr />
        <form
          class="needs-validation"
          ref="dataCreate"
          :model="dataCreate"
          @submit.prevent="submitForm()"
        >
          <div class="form-row">
            <div class="col-md-4 mb-3" prop="title">
              <label><span class="text-danger">*</span> Tiêu đề banner </label>
              <input
                type="text"
                v-model="dataCreate.title"
                class="form-control"
                aria-describedby="emailHelp"
                placeholder="Nhập đề banner"
                required
              />
            </div>
            <div class="col-md-4 mb-3" prop="titleEn">
              <label>Tiêu đề banner EN </label>
              <input
                v-model="dataCreate.titleEn"
                type="text"
                class="form-control"
                placeholder="Nhập tiêu đề banner EN"
              />
            </div>
            <div class="col-md-4 mb-3" prop="content">
              <label><span class="text-danger">*</span> Nội dung banner</label>
              <input
                v-model="dataCreate.content"
                type="text"
                class="form-control"
                placeholder="Nhập nội dung banner"
                required
              />
            </div>
            <div class="col-md-4 mb-3" prop="contentEn">
              <label>Nội dung banner EN </label>
              <input
                v-model="dataCreate.contentEn"
                type="text"
                class="form-control"
                placeholder="Nhập nội dung banner EN"
              />
            </div>
            <div class="col-md-4 mb-3" prop="titlePicture">
              <label><span class="text-danger">*</span> Alt ảnh</label>
              <input
                v-model="dataCreate.titlePicture"
                type="text"
                class="form-control"
                placeholder="Nhập alt ảnh"
                required
              />
            </div>
            <div class="col-md-4 mb-3" prop="titlePictureEn">
              <label>Alt ảnh EN</label>
              <input
                v-model="dataCreate.titlePictureEn"
                type="text"
                class="form-control"
                placeholder="Nhập alt ảnh EN"
              />
            </div>
            <div class="col-md-4 mb-3" prop="sort">
              <label>Vị trí banner</label>
              <input
                v-model="dataCreate.sort"
                type="number"
                class="form-control"
                placeholder="Nhập vị trí banner"
              />
            </div>
            <div class="col-md-4 mb-3" v-if="update == true">
              <label>Trạng thái </label>
              <select
                class="form-select form-select-lg col-md-12"
                style="padding: 5px 0 6px 5px"
                v-model="dataCreate.status"
              >
                <option selected value="1">Active</option>
                <option value="0">Hide</option>
              </select>
            </div>

            <!-- <div class="form-check">
              <input
                type="checkbox"
                class="form-check-input"
                id="exampleCheck1"
              />
              <label class="form-check-label" for="exampleCheck1"
                >Check me out</label
              >
            </div> -->
          </div>
          <div class="input-group-prepend">
            <p>Upload ảnh banner <i>(1920 x 1080)</i></p>
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
          <div class="col-12 button-submit">
            <button class="btn btn-primary" type="submit" v-if="!update">
              Save
            </button>
          </div>
        </form>
        <button
          class="btn btn-primary"
          v-if="update"
          @click="updateInfoNick(dataCreate)"
        >
          Update
        </button>
      </div>
    </div>
  </transition>
</template>

<script>
const config = {
  headers: { "content-type": "multipart/form-data" },
};
export default {
  name: "addNick",
  props: {
    active: { type: Boolean, default: false },
  },
  data() {
    return {
      dataCreate: {
        title: "",
        titleEn: "",
        content: "",
        contentEn: "",
        titlePicture: "",
        titlePictureEn: "",
        sort: "",
      },
      update: false,
      loadingButton: false,
      images: "",
      photos: "",
    };
  },
  methods: {
    updateInfoNick(data) {
      axios
        .put("/api/nick/update", data)
        .then((resp) => {
          this.handleBackdropClick();
          Swal.fire({
            icon: "success",
            title: "Update thành công",
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
    submitForm() {
      let formDatas = new FormData();
      if (this.photos != "") {
        formDatas.append("photos", this.photos);
      }
      for (var key in this.dataCreate) {
        formDatas.append(key, this.dataCreate[key]);
      }
      axios
        .post("/api/home/banner", formDatas, config)
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
    handleBackdropClick() {
      this.$emit("update:active", false);
      this.closeDialog();
      this.update = false;
    },
    searchDetail(data) {
      this.dataCreate = data;
      this.update = true;
      // alert(this.dataCreate.status_nick);
    },
    closeDialog() {
      for (var key in this.dataCreate) {
        this.dataCreate[key] = "";
      }
      this.images = "";
      this.photos = "";
      this.$parent.searchPropertis();
    },
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
    // uploadImage() {
    //   axios.post("/image/store", { image: this.image }).then((response) => {
    //     if (response.data.success) {
    //       alert(response.data.success);
    //     }
    //   });
    // },
  },
  // beforeMount() {
  //   this.searchPropertis();
  // },
};
</script>

<style scoped>
.remove-button {
  position: absolute;
  bottom: 19px;
  left: 15px;
  margin-bottom: -1px;
}
.button-submit {
  margin: 10px 0;
  padding: 0;
}
.custom-file {
  padding: 2px;
}
.dialog-backdrop {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.5);
}

.dialog-container {
  max-width: 70%;
  box-shadow: 0 11px 15px -7px rgba(0, 0, 0, 0.2),
    0 24px 38px 3px rgba(0, 0, 0, 0.14), 0 9px 46px 8px rgba(0, 0, 0, 0.12);
  margin-top: 30px;
  margin-left: auto;
  margin-right: auto;
  padding: 15px;
  background-color: #fff;
}

.dialog-enter-active,
.dialog-leave-active {
  transition: opacity 0.2s;
}
.dialog-enter,
.dialog-leave-to {
  opacity: 0;
}

.dialog-enter-active .dialog-container,
.dialog-leave-active .dialog-container {
  transition: transform 0.4s;
}
.dialog-enter .dialog-container,
.dialog-leave-to .dialog-container {
  transform: scale(0.9);
}
</style>