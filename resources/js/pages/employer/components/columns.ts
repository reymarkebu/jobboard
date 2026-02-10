import { ColumnDef } from '@tanstack/vue-table'
import DropdownAction from './DataTableDropDown.vue';
import { h } from 'vue'
import { ArrowUpDown, ChevronDown } from 'lucide-vue-next'
import { Button } from '@/components/ui/button';


export const columns: ColumnDef<JobOpening>[] = [
  {
    accessorKey: 'id',
    header: ({ column }) => {
      return h(Button, {
        variant: 'ghost',
        onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
      }, () => ['IDs', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
    },
    cell: ({ row }) => h('div', { class: 'text-center' }, row.getValue('id')),
  },
  {
    accessorKey: 'title',
    header: ({ column }) => {
      return h(Button, {
        variant: 'ghost',
        onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
      }, () => ['Title', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
    },
    cell: ({ row }) => h('div', { class: 'text-center' }, row.getValue('title')),
  },
  {
    accessorKey: 'description',
    header: ({ column }) => {
      return h(Button, {
        variant: 'ghost',
        onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
      }, () => ['Description', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
    },
    cell: ({ row }) => h('div', { class: 'text-center' }, row.getValue('description')),
  },
  {
    accessorKey: 'created_at',
    header: ({ column }) => {
      return h(Button, {
        variant: 'ghost',
        onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
      }, () => ['Created At', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
    },
    cell: ({ row }) => {
      return h('div', { class: 'text-center' }, row.getValue('created_at'))
    }
  },
  {
      id: 'actions',
      enableHiding: false,
      cell: ({ row, table }) => {
        const lead = { ...row.original }   // clean shallow copy (removes internals)
        return h('div', { class: 'relative' }, h(DropdownAction, {
          lead,
          onEdit: (id: number) => table.options.meta?.edit(lead),
          onDelete: (id: number) => table.options.meta?.delete(lead.id),
        }))
      },
    },

]
