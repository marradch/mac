<script setup lang="ts">
const { t } = useI18n()
</script>

<template>
  <div class="bg-[#3B2A20] shadow-sm z-50 mt-20 md:mt-24">
    <div class="max-w-screen-2xl mx-auto px-4 md:px-8 xl:px-12">
      <footer class="flex flex-col md:flex-row justify-start py-5 gap-4 md:gap-8 text-white text-sm">
        <ul class="leading-relaxed">
            <li class="font-bold mb-1 md:mb-2">{{ t('footer.legal') }}</li>
            <li>
                <NuxtLink to="/privacy-policy" class="text-red-200 hover:text-red-100 transition-colors">
                    {{ t('footer.privacy_policy') }}
                </NuxtLink>
            </li>
            <li>
                <NuxtLink to="/terms-of-service" class="text-red-200 hover:text-red-100 transition-colors">
                    {{ t('footer.terms_of_service') }}
                </NuxtLink>
            </li>
        </ul>
        <ul class="leading-relaxed">
            <li class="font-bold mb-1 md:mb-2">{{ t('footer.company') }}</li>
            <li>
                <NuxtLink to="/contacts" class="text-red-200 hover:text-red-100 transition-colors">
                  {{ t('footer.contacts') }}
                </NuxtLink>
            </li>
            <li>
                <NuxtLink to="/faq" class="text-red-200 hover:text-red-100 transition-colors">
                  {{ t('footer.faq') }}
                </NuxtLink>
            </li>
        </ul>

      </footer>
    </div>
  </div>
</template>