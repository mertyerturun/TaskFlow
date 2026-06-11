import subprocess

dates = [
    "2026-05-22T10:14:33",
    "2026-05-24T14:30:07",
    "2026-05-26T09:52:41",
    "2026-05-28T16:20:15",
    "2026-05-30T11:08:55",
    "2026-06-01T13:45:22",
    "2026-06-03T10:33:47",
    "2026-06-05T15:17:08",
    "2026-06-08T09:40:31",
    "2026-06-11T11:25:19",
]

result = subprocess.run(
    ["git", "log", "--oneline", "--reverse"],
    capture_output=True, text=True
)
commits = [line.split()[0] for line in result.stdout.strip().split('\n')]

if len(commits) != len(dates):
    print(f"HATA: {len(commits)} commit var, {len(dates)} tarih tanimlandi!")
    exit(1)

for i, (commit, date) in enumerate(zip(commits, dates)):
    print(f"[{i+1}/{len(commits)}] {commit} -> {date}")

env_filter = ""
for commit, date in zip(commits, dates):
    env_filter += f'[ "$GIT_COMMIT" = "{commit}" ] && export GIT_AUTHOR_DATE="{date}" && export GIT_COMMITTER_DATE="{date}"\n'

subprocess.run(
    ["git", "filter-branch", "-f", "--env-filter", env_filter, "--", "--all"],
    check=True
)

print("\nBitti! Kontrol: git log --date=short --format='%h %ad %s'")