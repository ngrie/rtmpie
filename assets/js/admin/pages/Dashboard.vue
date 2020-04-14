<template>
  <div>
    <PageHeader>
      <PageTitle>Dashboard</PageTitle>
    </PageHeader>
    <PageWrapper>
      content
    </PageWrapper>
  </div>
</template>

<script>
  import PageWrapper from 'ui/layout/PageWrapper'
  import PageHeader from 'ui/layout/PageHeader'
  import PageTitle from 'ui/layout/PageTitle'

  export default {
    name: 'Dashboard',
      components: { PageTitle, PageHeader, PageWrapper },
  }
</script>
