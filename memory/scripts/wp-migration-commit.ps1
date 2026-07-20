param(
    [Parameter(Mandatory = $true)]
    [ValidateSet('gate', 'build', 'seo', 'qa', 'rollout', 'handoff', 'misc')]
    [string]$Stage,

    [Parameter(Mandatory = $true)]
    [string]$Message
)

$stageFiles = @{
    gate = @(
        'memory/WORDPRESS_CAPABILITY_MATRIX.md',
        'memory/DECISIONS.md',
        'memory/CRITICAL_REMEDIATION_ACTIONS.md',
        'memory/WORKLOG.md'
    )
    build = @(
        'memory/BUILD_LOG.md',
        'memory/BUILD_TEMPLATE_LIST.md',
        'memory/WORDPRESS_PREPARATION_COORDINATION_PLAN.md',
        'memory/WORKLOG.md'
    )
    seo = @(
        'memory/SEO_MIGRATION_MATRIX.md',
        'memory/QA_SMOKE_CHECKS.md',
        'memory/WORKLOG.md'
    )
    qa = @(
        'memory/SEO_MIGRATION_MATRIX.md',
        'memory/QA_SMOKE_CHECKS.md',
        'memory/WORKLOG.md'
    )
    rollout = @(
        'memory/ROLLING_PLAN.md',
        'memory/RISK_LOG.md',
        'memory/WORKLOG.md'
    )
    handoff = @(
        'memory/WORKLOG.md',
        'memory/WORDPRESS_CAPABILITY_MATRIX.md'
    )
    misc = @(
        'memory/*.md',
        'memory/subagents/*.md'
    )
}

$files = $stageFiles[$Stage]

git add -- $files
git commit -m "wp-migration($Stage): $Message"