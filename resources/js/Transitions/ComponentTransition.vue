<script>
// JavaScript hooks logic...
</script>

<template>
  <!-- wrap the built-in Transition component -->
  <Transition>
    <slot></slot> <!-- pass down slot content -->
  </Transition>
</template>

<style>
/* we will explain what these classes do next! */
.v-enter-active,
.v-leave-active {
  transition: opacity .5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>