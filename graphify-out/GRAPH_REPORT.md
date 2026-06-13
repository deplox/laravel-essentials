# Graph Report - .  (2026-06-12)

## Corpus Check
- Corpus is ~15,303 words - fits in a single context window. You may not need a graph.

## Summary
- 266 nodes · 313 edges · 40 communities (21 shown, 19 thin omitted)
- Extraction: 95% EXTRACTED · 5% INFERRED · 0% AMBIGUOUS · INFERRED: 16 edges (avg confidence: 0.85)
- Token cost: 0 input · 0 output

## Community Hubs (Navigation)
- [[_COMMUNITY_Composer Package Config|Composer Package Config]]
- [[_COMMUNITY_Database & README Concepts|Database & README Concepts]]
- [[_COMMUNITY_Database Commands|Database Commands]]
- [[_COMMUNITY_Dogma Principles Engine|Dogma Principles Engine]]
- [[_COMMUNITY_Overseer Manager|Overseer Manager]]
- [[_COMMUNITY_graphify Skill Docs|graphify Skill Docs]]
- [[_COMMUNITY_Throttler Rate Limiting|Throttler Rate Limiting]]
- [[_COMMUNITY_CSP Middleware|CSP Middleware]]
- [[_COMMUNITY_ForceHttps Middleware|ForceHttps Middleware]]
- [[_COMMUNITY_LogRequests Middleware|LogRequests Middleware]]
- [[_COMMUNITY_UseHeaderGuards Middleware|UseHeaderGuards Middleware]]
- [[_COMMUNITY_UseRequestId Middleware|UseRequestId Middleware]]
- [[_COMMUNITY_Environment Inspector|Environment Inspector]]
- [[_COMMUNITY_Router Inspector|Router Inspector]]
- [[_COMMUNITY_Service Provider Boot|Service Provider Boot]]
- [[_COMMUNITY_Create Database Action|Create Database Action]]
- [[_COMMUNITY_Delete Database Action|Delete Database Action]]
- [[_COMMUNITY_Test Base Setup|Test Base Setup]]
- [[_COMMUNITY_Overseer Facade|Overseer Facade]]
- [[_COMMUNITY_Aliases Inspector|Aliases Inspector]]
- [[_COMMUNITY_Bindings Inspector|Bindings Inspector]]
- [[_COMMUNITY_Extenders Inspector|Extenders Inspector]]
- [[_COMMUNITY_Instances Inspector|Instances Inspector]]
- [[_COMMUNITY_Providers Inspector|Providers Inspector]]
- [[_COMMUNITY_Dogma Manager Tests|Dogma Manager Tests]]
- [[_COMMUNITY_General Principle Tests|General Principle Tests]]
- [[_COMMUNITY_Watch Folder Feature|Watch Folder Feature]]
- [[_COMMUNITY_MCP Server Export|MCP Server Export]]
- [[_COMMUNITY_Neo4j Export|Neo4j Export]]
- [[_COMMUNITY_Token Benchmark|Token Benchmark]]
- [[_COMMUNITY_Cluster-Only Update|Cluster-Only Update]]

## God Nodes (most connected - your core abstractions)
1. `graphify Knowledge Graph Pipeline` - 15 edges
2. `Throttler` - 13 edges
3. `OverseerManager` - 12 edges
4. `laravel-essentials Package` - 11 edges
5. `EssentialsConfig` - 8 edges
6. `EssentialsServiceProvider` - 8 edges
7. `DogmaManager` - 7 edges
8. `DbDropCommand` - 6 edges
9. `DbMakeCommand` - 6 edges
10. `config` - 5 edges

## Surprising Connections (you probably didn't know these)
- `CI Test Pipeline (GitHub Actions)` --references--> `laravel-essentials Package`  [INFERRED]
  .github/workflows/tests.yml → README.md
- `Native CLAUDE.md Integration` --references--> `laravel-essentials Package`  [EXTRACTED]
  .claude/skills/graphify/references/hooks.md → README.md
- `Post-Commit Auto-Rebuild Hook` --conceptually_related_to--> `Incremental Graph Update (--update)`  [INFERRED]
  .claude/skills/graphify/references/hooks.md → .claude/skills/graphify/references/update.md
- `graphify Skill` --references--> `graphify Knowledge Graph Pipeline`  [EXTRACTED]
  .claude/CLAUDE.md → .claude/skills/graphify/SKILL.md
- `graphify Knowledge Graph Pipeline` --references--> `URL Ingestion (graphify add)`  [EXTRACTED]
  .claude/skills/graphify/SKILL.md → .claude/skills/graphify/references/add-watch.md

## Import Cycles
- None detected.

## Hyperedges (group relationships)
- **Dogma Principles (all four apply EssentialsConfig)** — readme_http_principle, readme_model_principle, readme_database_principle, readme_general_principle, readme_essentials_config, readme_dogma_manager [EXTRACTED 1.00]
- **graphify Full Build Pipeline (Steps 1-9)** — skills_skill_ast_extraction, skills_skill_semantic_extraction, skills_skill_graph_build_cluster, skills_skill_community_labeling, skills_skill_obsidian_html_export [EXTRACTED 1.00]
- **Laravel Essentials Security Middleware** — readme_middleware_use_header_guards, readme_middleware_force_https, readme_middleware_csp, readme_middleware_use_request_id [INFERRED 0.85]

## Communities (40 total, 19 thin omitted)

### Community 0 - "Composer Package Config"
Cohesion: 0.06
Nodes (32): pestphp/pest-plugin, authors, autoload, autoload-dev, psr-4, psr-4, config, allow-plugins (+24 more)

### Community 1 - "Database & README Concepts"
Cohesion: 0.11
Nodes (26): CreateDatabase Action, DatabasePrinciple, db:drop Artisan Command, db:make Artisan Command, db:wait Artisan Command, DeleteDatabase Action, DogmaManager, EssentialsConfig (+18 more)

### Community 2 - "Database Commands"
Cohesion: 0.14
Nodes (14): CacheRepository, Command, DbDropCommand, DbMakeCommand, DbWaitCommand, Confirmable, HealthCommand, CreateDatabase (+6 more)

### Community 3 - "Dogma Principles Engine"
Cohesion: 0.11
Nodes (9): DogmaManager, DatabasePrinciple, GeneralPrinciple, HttpPrinciple, ModelPrinciple, EssentialsConfig, EssentialsConfig, EssentialsConfig (+1 more)

### Community 4 - "Overseer Manager"
Cohesion: 0.15
Nodes (5): Arrayable, Collection, OverseerManager, self, EssentialsConfig

### Community 5 - "graphify Skill Docs"
Cohesion: 0.15
Nodes (19): graphify Skill, URL Ingestion (graphify add), Wiki Export (--wiki), Extraction Subagent Prompt Template, GitHub Repo Clone and Cross-Repo Merge, Post-Commit Auto-Rebuild Hook, BFS/DFS Graph Traversal, Query Result Feedback Loop (save-result) (+11 more)

### Community 6 - "Throttler Rate Limiting"
Cohesion: 0.15
Nodes (3): RateLimiter, Closure, Throttler

### Community 7 - "CSP Middleware"
Cohesion: 0.53
Nodes (4): ContentSecurityPolicy, Closure, Request, Response

### Community 8 - "ForceHttps Middleware"
Cohesion: 0.53
Nodes (4): ForceHttps, Closure, Request, Response

### Community 9 - "LogRequests Middleware"
Cohesion: 0.53
Nodes (4): LogRequests, Closure, Request, Response

### Community 10 - "UseHeaderGuards Middleware"
Cohesion: 0.53
Nodes (4): UseHeaderGuards, Closure, Request, Response

### Community 11 - "UseRequestId Middleware"
Cohesion: 0.53
Nodes (4): UseRequestId, Closure, Request, Response

## Knowledge Gaps
- **49 isolated node(s):** `$schema`, `name`, `type`, `description`, `license` (+44 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **19 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **What connects `$schema`, `name`, `type` to the rest of the system?**
  _50 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `Composer Package Config` be split into smaller, more focused modules?**
  _Cohesion score 0.06060606060606061 - nodes in this community are weakly interconnected._
- **Should `Database & README Concepts` be split into smaller, more focused modules?**
  _Cohesion score 0.11076923076923077 - nodes in this community are weakly interconnected._
- **Should `Database Commands` be split into smaller, more focused modules?**
  _Cohesion score 0.14 - nodes in this community are weakly interconnected._
- **Should `Dogma Principles Engine` be split into smaller, more focused modules?**
  _Cohesion score 0.10666666666666667 - nodes in this community are weakly interconnected._
- **Should `Overseer Manager` be split into smaller, more focused modules?**
  _Cohesion score 0.14761904761904762 - nodes in this community are weakly interconnected._
- **Should `graphify Skill Docs` be split into smaller, more focused modules?**
  _Cohesion score 0.14619883040935672 - nodes in this community are weakly interconnected._