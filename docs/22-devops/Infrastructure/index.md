# Infrastructure

> PRD — Volume 22: DevOps — Infrastructure

## Overview

This document covers server specifications, auto-scaling configuration, load balancing, CDN setup, DNS management, and SSL/TLS configuration for the gsmui platform.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Uptime | Application availability | 99.95% |
| Page load time | Time to first byte | < 200ms |
| Global latency | Response time (P95) | < 500ms |
| Auto-scaling | Scale-up response time | < 2 minutes |
| SSL | Certificate validity | 90+ days auto-renew |

## Server Specifications

### Production Environment

| Component | Provider | Instance | Specs | Quantity |
|-----------|----------|----------|-------|----------|
| App Server | AWS EC2 | t3.large | 2 vCPU, 8GB RAM | 2+ (auto-scaled) |
| Database | AWS RDS | db.r6g.large | 2 vCPU, 16GB RAM | 1 primary + 1 replica |
| Cache | AWS ElastiCache | cache.r6g.large | 2 vCPU, 13GB RAM | 1 primary + 1 replica |
| Queue | AWS EC2 | t3.medium | 2 vCPU, 4GB RAM | 1+ |
| Load Balancer | AWS ALB | — | — | 1 |
| CDN | CloudFront | — | — | 1 distribution |

### Development Environment

| Component | Provider | Instance | Specs | Quantity |
|-----------|----------|----------|-------|----------|
| App Server | DigitalOcean | s-2vcpu-4gb | 2 vCPU, 4GB RAM | 1 |
| Database | DigitalOcean | db-s-1vcpu-1gb | 1 vCPU, 1GB RAM | 1 |
| Cache | DigitalOcean | db-s-1vcpu-1gb | 1 vCPU, 1GB RAM | 1 |

## Auto-Scaling

### Scaling Policy

| Metric | Threshold | Action | Cooldown |
|--------|-----------|--------|----------|
| CPU Utilization | > 70% for 5 min | Add 1 instance | 180s |
| CPU Utilization | < 30% for 10 min | Remove 1 instance | 300s |
| Request Count | > 1000/min for 5 min | Add 1 instance | 180s |
| Queue Depth | > 50 for 10 min | Add 1 worker | 180s |
| Memory Usage | > 80% for 5 min | Add 1 instance | 180s |

### Auto-Scaling Group

```yaml
# AWS Auto Scaling Group
AutoScalingGroup:
  Type: AWS::AutoScaling::AutoScalingGroup
  Properties:
    MinSize: 2
    MaxSize: 10
    DesiredCapacity: 2
    HealthCheckType: ELB
    HealthCheckGracePeriod: 300
    LaunchTemplate:
      LaunchTemplateName: gsmui-app
    VPCZoneIdentifier:
      - subnet-aaa111
      - subnet-bbb222
      - subnet-ccc333
    TargetGroupARNs:
      - !Ref AppTargetGroup
    Tags:
      - Key: Name
        Value: gsmui-app
        PropagateAtLaunch: true
```

### Scaling Policies

```yaml
ScaleUpPolicy:
  Type: AWS::AutoScaling::ScalingPolicy
  Properties:
    AutoScalingGroupName: !Ref AutoScalingGroup
    PolicyType: TargetTrackingScaling
    TargetTrackingConfiguration:
      PredefinedMetricSpecification:
        PredefinedMetricType: ASGAverageCPUUtilization
      TargetValue: 70.0
      ScaleInCooldown: 300
      ScaleOutCooldown: 180

ScaleUpQueuePolicy:
  Type: AWS::AutoScaling::ScalingPolicy
  Properties:
    AutoScalingGroupName: !Ref AutoScalingGroup
    PolicyType: StepScaling
    AdjustmentType: ChangeInCapacity
    StepAdjustments:
      - MetricIntervalLowerBound: 0
        MetricIntervalUpperBound: 50
        ScalingAdjustment: 1
      - MetricIntervalLowerBound: 50
        ScalingAdjustment: 2
```

## Load Balancing

### ALB Configuration

| Setting | Value |
|---------|-------|
| Type | Application Load Balancer |
| Scheme | Internet-facing |
| SSL | ACM certificate (auto-renew) |
| HTTP/2 | Enabled |
| Stickiness | Disabled (use Redis sessions) |
| Health Check Path | `/health` |
| Health Check Interval | 30 seconds |
| Healthy Threshold | 2 |
| Unhealthy Threshold | 3 |
| Idle Timeout | 60 seconds |

### Target Group Configuration

```yaml
AppTargetGroup:
  Type: AWS::ElasticLoadBalancingV2::TargetGroup
  Properties:
    Port: 80
    Protocol: HTTP
    VpcId: !Ref VPC
    HealthCheckEnabled: true
    HealthCheckPath: /health
    HealthCheckIntervalSeconds: 30
    HealthCheckTimeoutSeconds: 5
    HealthyThresholdCount: 2
    UnhealthyThresholdCount: 3
    Matcher:
      HttpCode: 200
    TargetGroupAttributes:
      - Key: deregistration_delay.timeout_seconds
        Value: 30
      - Key: stickiness.enabled
        Value: false
```

## CDN Configuration

### CloudFront Distribution

| Setting | Value |
|---------|-------|
| Origin | ALB DNS name |
| Default Root Object | `/` |
| SSL | Custom domain with ACM |
| HTTP/2 | Enabled |
| Compression | Gzip + Brotli |
| Default TTL | 86400 seconds (1 day) |
| Max TTL | 31536000 seconds (1 year) |

### Cache Behaviors

| Path Pattern | TTL | Compress | Query String | Cookies |
|-------------|-----|----------|--------------|---------|
| `/build/*` | 1 year | Yes | All | None |
| `/images/*` | 30 days | Yes | All | None |
| `/fonts/*` | 1 year | Yes | All | None |
| `/css/*` | 7 days | Yes | All | None |
| `/js/*` | 7 days | Yes | All | None |
| `/api/*` | 0 | No | All | All |
| `default` | 0 | Yes | All | All |

### Cache Invalidation

```bash
# Invalidate specific paths
aws cloudfront create-invalidation \
    --distribution-id E1234567890 \
    --paths "/build/*" "/images/*"

# Invalidate all
aws cloudfront create-invalidation \
    --distribution-id E1234567890 \
    --paths "/*"
```

## DNS Management

### DNS Records

| Record | Type | Value | TTL | Description |
|--------|------|-------|-----|-------------|
| `@` | A | ALB IP | 60 | Root domain |
| `www` | CNAME | `example.com` | 60 | WWW subdomain |
| `_acme` | TXT | ACM validation | 300 | SSL validation |
| `mail` | MX | `10 mail.example.com` | 3600 | Email |
| `mail` | A | Mail server IP | 3600 | Mail server |

### DNS Configuration

```yaml
# Route 53 Hosted Zone
HostedZone:
  Type: AWS::Route53::HostedZone
  Properties:
    Name: example.com

RecordSet:
  Type: AWS::Route53::RecordSet
  Properties:
    HostedZoneId: !Ref HostedZone
    Name: example.com
    Type: A
    AliasTarget:
      DNSName: !GetAtt LoadBalancer.DNSName
      HostedZoneId: !GetAtt LoadBalancer.CanonicalHostedZoneID

WWWRecord:
  Type: AWS::Route53::RecordSet
  Properties:
    HostedZoneId: !Ref HostedZone
    Name: www.example.com
    Type: CNAME
    TTL: 60
    ResourceRecords:
      - example.com
```

## SSL/TLS Configuration

### Certificate Management

| Setting | Value |
|---------|-------|
| Provider | AWS ACM |
| Validation | DNS (Route 53) |
| Auto-Renewal | Yes |
| Protocol | TLS 1.2+ |
| HSTS | Enabled (max-age: 31536000) |

### SSL Configuration

```nginx
# Nginx SSL configuration
listen 443 ssl http2;
ssl_certificate /etc/letsencrypt/live/example.com/fullchain.pem;
ssl_certificate_key /etc/letsencrypt/live/example.com/privkey.pem;
ssl_protocols TLSv1.2 TLSv1.3;
ssl_ciphers ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256;
ssl_prefer_server_ciphers off;
ssl_session_cache shared:SSL:10m;
ssl_session_timeout 10m;

# Security headers
add_header Strict-Transport-Security "max-age=31536000; includeSubDomains; preload" always;
add_header X-Frame-Options "SAMEORIGIN" always;
add_header X-Content-Type-Options "nosniff" always;
add_header X-XSS-Protection "1; mode=block" always;
add_header Referrer-Policy "strict-origin-when-cross-origin" always;
```

## Infrastructure Diagram

```
Internet
    │
    ▼
┌───────────────────────────────────────────────────────────┐
│                        Route 53                           │
│                   (DNS + Failover)                        │
└───────────────────────────┬───────────────────────────────┘
                            │
                    ┌───────┴───────┐
                    │               │
                    ▼               ▼
            ┌──────────────┐ ┌──────────────┐
            │  CloudFront  │ │  CloudFront  │
            │  (Primary)   │ │  (Standby)   │
            └──────┬───────┘ └──────┬───────┘
                   │                │
                   └───────┬────────┘
                           │
                    ┌──────┴──────┐
                    │     ALB     │
                    │  (SSL/TLS)  │
                    └──────┬──────┘
                           │
              ┌────────────┼────────────┐
              │            │            │
        ┌─────┴─────┐ ┌───┴────┐ ┌─────┴─────┐
        │  App #1   │ │ App #2 │ │  App #N   │
        └─────┬─────┘ └───┬────┘ └─────┬─────┘
              │            │            │
              └────────────┼────────────┘
                           │
                    ┌──────┴──────┐
                    │   Redis     │
                    │  (Cluster)  │
                    └──────┬──────┘
                           │
                    ┌──────┴──────┐
                    │   MySQL     │
                    │  (RDS)      │
                    └─────────────┘
```

## Acceptance Criteria

- [ ] Auto-scaling adds instances within 2 minutes of threshold breach
- [ ] Load balancer distributes traffic evenly across instances
- [ ] CDN serves static assets with 95%+ cache hit rate
- [ ] SSL certificates auto-renew before expiration
- [ ] DNS failover switches traffic in under 5 minutes
- [ ] Health checks detect failed instances within 60 seconds
- [ ] Auto-scaling removes unused instances within 10 minutes
- [ ] HSTS header is present on all responses
- [ ] HTTP/2 is enabled for all connections
- [ ] Infrastructure scales to handle 10x normal traffic
