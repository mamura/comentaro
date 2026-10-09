import { cva, type VariantProps } from 'class-variance-authority'
import type { HTMLAttributes } from 'react'
import { cn } from '@/lib/utils'

const badgeVariants = cva(
  'inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold',
  {
    variants: {
      status: {
        checking: 'bg-slate-100 text-slate-600',
        online: 'bg-emerald-100 text-emerald-800',
        offline: 'bg-rose-100 text-rose-800',
      },
    },
    defaultVariants: { status: 'checking' },
  },
)

type StatusBadgeProps = HTMLAttributes<HTMLSpanElement> &
  VariantProps<typeof badgeVariants>

export function StatusBadge({ className, status, ...props }: StatusBadgeProps) {
  return <span className={cn(badgeVariants({ status }), className)} {...props} />
}
