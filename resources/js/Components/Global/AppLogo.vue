<template>
  <Link
    href="/"
    class="flex items-center space-x-3 cursor-pointer rounded-full rtl:space-x-reverse"
  >
    <!-- <img
      src="https://flowbite.com/docs/images/logo.svg"
      class="h-8 w-8 hidden sm:block rounded-full"
      alt="Flowbite Logo"
    /> -->
    <span
      class="font-bold italic"
      :class="
        $page.component === 'Dashboard'
          ? 'text-xl sm:text-2xl text-gray-50'
          : $page.component === 'Home'
          ? 'text-xl sm:text-3xl text-gray-50'
          : 'text-2xl sm:text-3xl text-gray-900 dark:text-gray-50'
      "
    >
      yourmenupage
    </span>
  </Link>
</template>
