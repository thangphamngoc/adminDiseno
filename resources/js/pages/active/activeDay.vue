<template>
  <div class="app-content">
    <div class="search-group">
      <!-- <select class="custom-select col-sm-3 col-md-2 col-12">
        <option selected value="active">Đang làm</option>
        <option selected value="noActive">Nghỉ làm</option>
        <option value="full">Tạm nghỉ</option>
      </select> -->
      <div class="input-group">
        <!-- <div class="form-group row"> -->
        <!-- <label for="example-date-input" class="col-2 col-form-label"
            >Date</label
          > -->
        <div class="col-sm-3 col-md-3 col-12 custom-date">
          <input
            class="form-control col-12"
            type="date"
            v-model="dataSearch.date"
            id="example-date-input"
          />
        </div>
        <!-- </div> -->
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
            <th>
              <label class="form-checkbox">
                <input type="checkbox" v-model="selectAll" @click="select" />
                <i class="form-icon"></i>
              </label>
            </th>
            <th scope="col">STT</th>
            <th scope="col">Họ và tên</th>
            <th scope="col">SĐT</th>
            <th scope="col">Facebook</th>
            <!-- <th scope="col">STK</th>
            <th scope="col">Địa chỉ</th>
            <th scope="col">Học vấn</th>
            <th scope="col">Ngày bắt đầu</th> -->
            <th scope="col">Trạng thái</th>
            <th scope="col"><span>Tác vụ</span></th>
          </tr>
        </thead>
        <tbody>
          <tr class="text-center" v-for="(item, key) in responseList">
            <td>
              <label class="form-checkbox">
                <input type="checkbox" :value="item.id" v-model="selected" />
                <i class="form-icon"></i>
              </label>
            </td>
            <th scope="row" type="index">{{ key + 1 }}</th>
            <td class="text-left">{{ item.full_name }}</td>
            <td>{{ item.phone }}</td>
            <td>{{ item.facebook }}</td>
            <!-- <td>{{ item.bank }}</td>
            <td class="text-left">{{ item.address }}</td>
            <td>{{ item.education_level }}</td>
            <td>{{ item.created_at }}</td> -->
            <td>
              <span v-if="item.employee_status == 1">Đang làm</span>
              <span v-else-if="item.employee_status == 0">Nghỉ làm</span>
              <span v-else-if="item.employee_status == 2">Tạm nghỉ</span>
            </td>

            <td>
              <button
                type="button"
                class="btn btn-success"
                @click="createTotalDay(item)"
              >
                Create
              </button>
              <button type="button" class="btn btn-danger">Delete</button>
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
          <a class="dropdown-item" href="#">Tạm nghỉ</a>
          <a class="dropdown-item" href="#">Đi làm</a>
          <a class="dropdown-item" href="#">Nghỉ làm</a>
          <!-- <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Separated link</a> -->
        </div>
      </div>
    </div>
    <add-project
      :active.sync="showCreateDialog"
      @dialog-close="dialogCloseCreateMethod()"
      ref="AddProject"
    />
  </div>
</template>
<script>
import moment from "moment";
import AddProject from '../projects/addProject.vue';

export default {
  components: {
    ctvAdd,
    AddProject,
  },
  middleware: "auth",
  metaInfo() {
    return { title: this.$t("managerCtv") };
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
      selected: [],
      selectAll: false,
      dataCreate: {
        date: "",
        id: "",
      },
    };
  },
  methods: {
    createTotalDay(data) {
      this.dataCreate.date = this.dataSearch.date;
      this.dataCreate.id = data.id;
      axios
        .post("/api/total/add", this.dataCreate)
        .then((resp) => {
          //   this.handleBackdropClick();
          Swal.fire({
            icon: "success",
            title: "Tạo thành công",
            showConfirmButton: false,
            timer: 1500,
          });
        })
        .catch((err) => {
          Swal.fire({
            icon: "error",
            title: "Tạo thất bại",
            showConfirmButton: false,
            timer: 1500,
          });
        });
    },
    select() {
      this.selected = [];
      if (!this.selectAll) {
        for (let i in this.responseList) {
          this.selected.push(this.responseList[i].id);
        }
      }
      console.log(this.selected);
    },
    createDialogMethod() {
      this.showCreateDialog = true;
    },
    editDialogMethod(data) {
      this.showCreateDialog = true;
      this.$refs.ctvAdd.searchDetail(data);
    },

    searchPropertis() {
      axios
        .get("/api/ctv/data")
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
</style>