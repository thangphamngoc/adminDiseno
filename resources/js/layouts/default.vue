<template>
  <div class="main-layout">
    <navbar />

    <div class="container-fluid mt-4 content-fluid">
      <NavbarLeft style="float: left" ref="addNick" />
      <child />
    </div>
  </div>
</template>

<script>
import Navbar from "~/components/Navbar";
import NavbarLeft from "~/components/NavbarLeft";

export default {
  name: "MainLayout",

  components: {
    Navbar,
    NavbarLeft,
  },
};
</script>

