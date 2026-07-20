[CmdletBinding(SupportsShouldProcess = $true)]
param(
    [int]$StaleDays = 45,
    [switch]$DeleteOrphans
)

$scriptRoot = Split-Path -Parent $MyInvocation.MyCommand.Path
$repoRoot = (Resolve-Path (Join-Path $scriptRoot '..\..')).Path
$memoryRoot = Join-Path $repoRoot 'memory'
$now = Get-Date
$staleAfter = $now.AddDays(-$StaleDays)
$reportDate = Get-Date -Format 'yyyy-MM-dd_HH-mm'
$reportPath = Join-Path $memoryRoot ("memory-cleanup-report-$reportDate.md")

$mandatoryRelative = @(
    'AGENTS.md',
    'memory\\README.md',
    'memory\\00-HOME.md',
    'memory\\01-NOW.md',
    'memory\\PROJECT.md',
    'memory\\DECISIONS.md',
    'memory\\WORKLOG.md',
    'memory\\EVIDENCE.md',
    'memory\\00-HOME.md',
    'memory\\WORDPRESS_MIGRATION_WORKFLOW.md',
    'memory\\WORDPRESS_SKILLS.md',
    'memory\\subagents\\00-SUBAGENTS.md',
    'memory\\subagents\\WORDPRESS_ASSIGNMENTS.md',
    'memory\\memory-cleanup-protocol.md'
)

$mandatory = New-Object 'System.Collections.Generic.HashSet[string]' ([System.StringComparer]::OrdinalIgnoreCase)
foreach ($item in $mandatoryRelative) {
    if ($item -like 'AGENTS.md') {
        $mandatory.Add((Join-Path $repoRoot 'AGENTS.md').ToLowerInvariant()) | Out-Null
    }
    else {
        $mandatory.Add((Join-Path $repoRoot $item).ToLowerInvariant()) | Out-Null
    }
}

$allFiles = Get-ChildItem -Path $memoryRoot -Recurse -File -Filter *.md | Sort-Object FullName
$referenced = New-Object 'System.Collections.Generic.HashSet[string]' ([System.StringComparer]::OrdinalIgnoreCase)

$linkPattern = '\[[^\]]+\]\(([^)\s]+)\)'
$allFiles | ForEach-Object {
    $text = Get-Content -Raw -Encoding UTF8 $_.FullName
    foreach ($match in [regex]::Matches($text, $linkPattern)) {
        $raw = $match.Groups[1].Value.Trim()

        if ($raw -match '^(https?|mailto:|tel:|#|javascript:|data:)') {
            continue
        }
        if ([string]::IsNullOrWhiteSpace($raw)) {
            continue
        }

        $clean = $raw -replace '#.*$', ''
        $clean = $clean -replace '^\.\/', ''
        $clean = $clean -replace '^\/', ''

        $candidate = $null
        if ($clean -like 'memory\\*' -or $clean -like 'memory/*') {
            $candidate = Join-Path $repoRoot $clean
        }
        else {
            $candidate = Join-Path (Split-Path $_.FullName -Parent) $clean
        }

        if ([IO.Path]::IsPathRooted($candidate) -and (Test-Path $candidate)) {
            $resolved = (Resolve-Path $candidate).Path.ToLowerInvariant()
            if ($resolved -like "$($memoryRoot.ToLowerInvariant())*") {
                $referenced.Add($resolved) | Out-Null
            }
        }
        else {
            $repoCandidate = Join-Path $repoRoot $clean
            if (Test-Path $repoCandidate) {
                $resolved = (Resolve-Path $repoCandidate).Path.ToLowerInvariant()
                if ($resolved -like "$($memoryRoot.ToLowerInvariant())*") {
                    $referenced.Add($resolved) | Out-Null
                }
            }
        }
    }
}

$allSet = New-Object 'System.Collections.Generic.HashSet[string]' ([System.StringComparer]::OrdinalIgnoreCase)
$allFiles | ForEach-Object { [void]$allSet.Add($_.FullName.ToLowerInvariant()) }

$orphanCandidates = @()
foreach ($file in $allFiles) {
    $full = $file.FullName.ToLowerInvariant()
    if ($mandatory.Contains($full)) { continue }
    if ($referenced.Contains($full)) { continue }
    $orphanCandidates += $file
}

$staleOrphans = $orphanCandidates | Where-Object { $_.LastWriteTime -lt $staleAfter }

$mandatoryList = @()
foreach ($item in $mandatoryRelative) {
    $mandatoryList += ((Join-Path $repoRoot $item.Replace('/', '\')).ToLowerInvariant())
}

$reportLines = @(
    "# Memory cleanup report",
    "",
    "- Date: $($now.ToString('yyyy-MM-dd HH:mm:ss'))",
    "- Repository: $repoRoot",
    "- Memory root: $memoryRoot",
    "- Stale window: last write older than $($staleAfter.ToString('yyyy-MM-dd'))",
    "",
    "## Mandatory files",
    ""
)
$reportLines += ($mandatoryList | Sort-Object | ForEach-Object { "- $_" })

$reportLines += @(
    "",
    "## Total files",
    "- count: $($allFiles.Count)",
    "",
    "## Referenced files",
    "- count: $($referenced.Count)"
)
$reportLines += @(
    "",
    "## Orphan candidates",
    "- count: $($orphanCandidates.Count)"
)
if ($orphanCandidates.Count -eq 0) {
    $reportLines += @("- нет кандидатов")
}
else {
    $orphanCandidates | Sort-Object FullName | ForEach-Object {
        $age = [Math]::Round((New-TimeSpan -Start $_.LastWriteTime -End $now).TotalDays, 1)
        $reportLines += "- $($_.FullName) (age: $age days, modified: $($_.LastWriteTime.ToString('yyyy-MM-dd')))"
    }
}

$reportLines += @(
    "",
    "## Stale orphans (candidate for review)",
    "- count: $($staleOrphans.Count)"
)
if ($staleOrphans.Count -eq 0) {
    $reportLines += @("- нет просроченных сиротних файлов")
}
else {
    $staleOrphans | Sort-Object FullName | ForEach-Object {
        $reportLines += "- $_"
    }
}

$reportLines += @(
    "",
    "## Delete mode",
    "- DeleteOrphans: $($DeleteOrphans.IsPresent)"
)

Set-Content -Path $reportPath -Value $reportLines -Encoding UTF8

Write-Host "Memory GC report: $reportPath"
Write-Host "Referenced: $($referenced.Count) / Total: $($allFiles.Count)"
Write-Host "Orphans: $($orphanCandidates.Count), stale: $($staleOrphans.Count)"

if ($DeleteOrphans) {
    if ($staleOrphans.Count -eq 0) {
        Write-Host "No stale files for deletion."
    }
    else {
        Write-Warning "Deletion requested. This will remove only stale orphan files. Use -Confirm with caution."
        foreach ($item in $staleOrphans) {
            if ($PSCmdlet.ShouldProcess($item.FullName, 'Remove stale orphan memory file')) {
                Remove-Item -LiteralPath $item.FullName -Force
                Write-Host "Deleted: $($item.FullName)"
            }
        }
    }
}
