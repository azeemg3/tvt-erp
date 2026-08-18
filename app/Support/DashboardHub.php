<?php

namespace App\Support;

/**
 * Permission-filtered cards for the four business modules on home / launcher.
 */
class DashboardHub
{
    /**
     * Overlay live notification counts onto matching tile badge_id values.
     *
     * @param  array<int, array>  $tiles
     * @param  array<string, int|string>  $counts
     * @return array<int, array>
     */
    public static function applyBadges(array $tiles, array $counts): array
    {
        foreach ($tiles as &$tile) {
            $id = $tile['badge_id'] ?? null;

            if ($id && ! empty($counts[$id])) {
                $tile['badge'] = $counts[$id];
            }
        }
        unset($tile);

        return $tiles;
    }

    /**
     * Cards for the registered business modules the user may open.
     *
     * @return array<int, array>
     */
    public static function moduleTiles($user = null): array
    {
        $tiles = [];

        foreach (ModuleManager::accessible($user) as $module) {
            $slug = $module['slug'];

            $tiles[] = [
                'title'       => $module['label'],
                'description' => $module['description'] ?? '',
                'icon'        => $module['icon'] ?? 'fas fa-cube',
                'color'       => $module['color'] ?? 'bg-gradient-primary',
                'href'        => route('modules.select', $slug),
                'cta'         => 'Open',
                'badge_id'    => static::moduleBadgeId($slug),
            ];
        }

        return $tiles;
    }

    protected static function moduleBadgeId(string $slug): ?string
    {
        $map = [
            'agent' => 'hub-badge-agent',
            'umrah' => 'hub-badge-umrah',
        ];

        return $map[$slug] ?? null;
    }
}
