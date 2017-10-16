<template>
	<div></div>
</template>
<script>
export default {
  created() {
      let from_menu = this.$route.query.menu;
    if (from_menu) {
      this.$router.replace({ path: from_menu })
    } else {
      this.$router.back();
    }
  }
}
</script>