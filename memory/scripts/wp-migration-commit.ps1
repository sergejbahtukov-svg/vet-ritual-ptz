param(
    [Parameter(Mandatory = $true)]
    [ValidateSet('gate', 'build', 'seo', 'qa', 'rollout', 'handoff', 'misc')]
    [string]$Stage,

    [Parameter(Mandatory = $true)]
    [string]$Message
)

function Get-RepoRoot {
    $root = (git rev-parse --show-toplevel).Trim()
    if (-not $root) { throw "Cannot determine git root." }
    return $root
}

function Resolve-StageFiles {
    param(
        [string]$Stage,
        [string]$RepoRoot
    )

    $memoryRoot = Join-Path -Path $RepoRoot -ChildPath 'memory'

    switch ($Stage) {
        'gate' {
            return @(
                'memory/WORDPRESS_CAPABILITY_MATRIX.md',
                'memory/DECISIONS.md',
                'memory/CRITICAL_REMEDIATION_ACTIONS.md',
                'memory/WORKLOG.md'
            )
        }
        'build' {
            return @(
                'memory/BUILD_LOG.md',
                'memory/BUILD_TEMPLATE_LIST.md',
                'memory/WORDPRESS_PREPARATION_COORDINATION_PLAN.md',
                'memory/WORKLOG.md'
            )
        }
        'seo' {
            return @(
                'memory/SEO_MIGRATION_MATRIX.md',
                'memory/QA_SMOKE_CHECKS.md',
                'memory/WORKLOG.md'
            )
        }
        'qa' {
            return @(
                'memory/SEO_MIGRATION_MATRIX.md',
                'memory/QA_SMOKE_CHECKS.md',
                'memory/WORKLOG.md'
            )
        }
        'rollout' {
            return @(
                'memory/ROLLING_PLAN.md',
                'memory/RISK_LOG.md',
                'memory/WORKLOG.md'
            )
        }
        'handoff' {
            return @(
                'memory/WORKLOG.md',
                'memory/WORDPRESS_CAPABILITY_MATRIX.md'
            )
        }
        'misc' {
            return Get-ChildItem -Path $memoryRoot -Recurse -File -Include '*.md' | ForEach-Object {
                $full = $_.FullName
                $relative = $full.Substring($RepoRoot.Length + 1)
                $relative = $relative.Replace('\', '/')
                $relative
            }
        }
    }
}

$repoRoot = Get-RepoRoot
$files = Resolve-StageFiles -Stage $Stage -RepoRoot $repoRoot

if (-not $files -or $files.Count -eq 0) {
    throw "No files resolved for stage '$Stage'."
}

$status = git status --short -- $files
if (-not $status) {
    throw "No changes detected for stage '$Stage'. Commit skipped to avoid empty commit."
}

git add -- $files
git commit -m "wp-migration($Stage): $Message"
