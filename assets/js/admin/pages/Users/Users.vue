<template>
  <div>
    <PageHeader>
      <PageTitle>Users</PageTitle>
      <template #actions>
        <BaseButton color="primary" :icon="['fas', 'plus']" @click="addModalOpen = true">
          Create user
        </BaseButton>
      </template>
    </PageHeader>

    <PageWrapper>
      <Table with-action-column :columns="['Username', 'Role']">
        <TableRow v-for="(user, index) in users" :key="user.id" :striped="index % 2 !== 0">
          <TableColumn bold>{{ user.username }}</TableColumn>
          <TableColumn>Administrator</TableColumn>
          <TableColumn class="text-right font-medium">
            <a
              href="#"
              class="text-indigo-600 hover:text-indigo-900"
              @click.prevent="openDeleteModal(user.id)"
            >
              Delete
            </a>
          </TableColumn>
        </TableRow>
      </Table>
    </PageWrapper>

    <AddUserModal v-model="addModalOpen" @created="fetch" />
    <DeleteUserConfirmDialog v-model="deleteModalOpen" @confirmed="deleteUser" />
  </div>
</template>

<script>
  import api from 'api'
  import PageHeader from 'ui/layout/PageHeader'
  import PageTitle from 'ui/layout/PageTitle'
  import PageWrapper from 'ui/layout/PageWrapper'
  import BaseButton from 'ui/BaseButton'
  import Table from 'ui/tables/Table'
  import TableRow from 'ui/tables/TableRow'
  import TableColumn from 'ui/tables/TableColumn'
  import AddUserModal from './AddUserModal'
  import DeleteUserConfirmDialog from './DeleteUserConfirmDialog'

  export default {
    name: 'Users',
    components: { DeleteUserConfirmDialog, AddUserModal, TableColumn, TableRow, Table, BaseButton, PageWrapper, PageTitle, PageHeader },
    data() {
      return {
        initialized: false,
        users: [],
        addModalOpen: false,
        deleteModalOpen: false,
        userToDelete: null,
      }
    },
    mounted() {
      this.fetch()
    },
    methods: {
      async fetch() {
        this.users = (await api('users')).data
        this.initialized = true
      },
      openDeleteModal(id) {
        this.userToDelete = id
        this.deleteModalOpen = true
      },
      async deleteUser() {
        if (!this.userToDelete) {
          return
        }

        await api.delete(`users/${this.userToDelete}`)
        this.fetch()
        this.userToDelete = null
      },
    },
  }
</script>
