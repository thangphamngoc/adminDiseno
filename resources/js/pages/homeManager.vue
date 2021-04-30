<template>
  <div class="app-content">
    <div class="search-group">
      <select class="custom-select col-sm-3 col-md-2 col-12">
        <option selected value="1">Đang hoạt động</option>
        <option value="0">Full bạn bè</option>
        <option value="2">Ngừng hoạt động</option>
        <option value="4">Die</option>
      </select>
      <div class="input-group">
        <div class="col-sm-3 col-md-2 col-12 custom-date">
          <input
            class="form-control"
            type="date"
            v-model="dataSearch.date"
            id="example-date-input"
          />
        </div>
        <div class="form-outline">
          <input
            type="search"
            placeholder="Nhập sđt or name"
            lab
            class="form-control"
          />
        </div>
        <button type="button" class="btn btn-primary search-mb">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </div>
    <div class="table-responsive-lg">
      <table class="table table-bordered table-hover">
        <thead>
          <tr class="table-nick text-center">
            <th scope="col" width="50px">STT</th>
            <th scope="col" min-width="140px">Title</th>
            <th scope="col" min-width="140px">Content</th>
            <th scope="col" width="100px">Title Img</th>
            <th scope="col" width="100px">Url</th>
            <th scope="col" width="50px">Sort</th>
            <th scope="col" width="150px">Ngày tạo</th>
            <th scope="col" width="120px">Trạng thái</th>
            <th scope="col" width="100px">Img</th>
            <th scope="col" width="150px"><span>Tác vụ</span></th>
          </tr>
        </thead>
        <tbody>
          <tr class="text-center" v-for="(item, key) in responseList">
            <th scope="row">{{ key + 1 }}</th>
            <td scope="row" class="text-left">{{ item.title }}</td>
            <td scope="row">{{ item.content }}</td>
            <td scope="row" class="text-left">{{ item.titlePicture }}</td>
            <td scope="row">
              <p class="hasTooltip">
                ...
                <span>{{ item.urlPicture }}</span>
              </p>
            </td>
            <td scope="row">{{ item.sort }}</td>
            <td scope="row">{{ item.created_at }}</td>
            <td>
              <span v-if="item.status == 1">Đang hoạt động</span>
              <span v-else>Đã ẩn</span>
            </td>
            <td scope="row">
              <img
                class="img-table"
                :src="item.urlPicture"
                :alt="item.titlePicture"
              />
            </td>
            <td>
              <button
                type="button"
                class="btn btn-warning"
                @click="editDialogMethod(item)"
              >
                Sửa
              </button>
              <button type="button" class="btn btn-success">Disable</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="d-flex justify-content-end">
      <button
        type="button"
        class="btn btn-success add-nick"
        @click="createDialogMethod()"
      >
        Thêm mới
      </button>
      <div class="btn-group">
        <button
          type="button"
          class="btn btn-success dropdown-toggle"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >
          Tác vụ
        </button>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="#">Duyệt</a>
          <a class="dropdown-item" href="#">Hủy Duyệt</a>
          <a class="dropdown-item" href="#">Active</a>
          <!-- <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Separated link</a> -->
        </div>
      </div>
    </div>
    <addNick
      :active.sync="showCreateDialog"
      @dialog-close="dialogCloseCreateMethod()"
      ref="addNick"
    />
  </div>
</template>
<script>
import addNick from "./addNick.vue";
import moment from "moment";

export default {
  components: {
    addNick,
  },
  middleware: "auth",
  metaInfo() {
    return { title: this.$t("managerNick") };
  },
  data() {
    return {
      multipleSelection: [],
      responseList: [],
      loaddingButton: false,
      showCreateDialog: false,
      showUpdateDialog: false,
      dataSearch: {
        name: "",
        date: moment(new Date()).format("YYYY-MM-DD"),
      },
    };
  },
  methods: {
    createDialogMethod() {
      this.showCreateDialog = true;
    },
    editDialogMethod(data) {
      this.showCreateDialog = true;
      this.$refs.addNick.searchDetail(data);
    },

    searchPropertis() {
      axios
        .get("/api/home/data")
        .then((resp) => {
          this.responseList = resp.data;
          console.log(this.responseList);
        })
        .catch((err) => {
          console.log(err);
          Swal.fire({
            icon: "error",
            title: "Lỗi dữ liệu",
            showConfirmButton: false,
            timer: 1500,
          });
        });
    },
  },
  beforeMount() {
    this.searchPropertis();
  },
};
</script>
<style lang="scss" scoped>
.add-nick {
  margin-right: 5px;
}
.img-table {
  max-height: 100px;
  max-width: 100px;
}
.hasTooltip span {
  display: none;
  color: #000;
  text-decoration: none;
  padding: 3px;
}

.hasTooltip:hover span {
  display: block;
  position: absolute;
  background-color: #fff;
  border: 1px solid #ccc;
  margin: 2px 10px;
}
</style>