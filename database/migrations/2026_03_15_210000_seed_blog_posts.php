<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $posts = [
            [
                'title'   => 'How to Crack FAANG Interviews: A Mentor\'s Proven Playbook',
                'slug'    => 'how-to-crack-faang-interviews',
                'excerpt' => 'Getting into Google, Amazon, or Microsoft from India is achievable — but only with the right preparation strategy. Here is the exact roadmap mentors recommend.',
                'content' => <<<'HTML'
<p>Every year, thousands of Indian engineers dream of landing a role at Google, Amazon, Meta, Apple, or Microsoft. Yet most preparation is unfocused — grinding LeetCode for months without a real strategy. The candidates who actually land offers follow a structured plan, often guided by someone who has done it before.</p>

<h3>Phase 1: Foundation (Weeks 1–4)</h3>
<p>Before you touch a single algorithm problem, solidify your fundamentals:</p>
<ul>
<li><strong>Data Structures:</strong> Arrays, Linked Lists, Stacks, Queues, Trees, Graphs, Heaps, Hash Maps</li>
<li><strong>Algorithms:</strong> Sorting, Searching, BFS/DFS, Dynamic Programming, Greedy</li>
<li><strong>Complexity Analysis:</strong> Big-O in time and space — interviewers expect this in every solution</li>
</ul>

<h3>Phase 2: Pattern Recognition (Weeks 5–10)</h3>
<p>FAANG interviews use a limited set of problem patterns. Learning to spot patterns — sliding window, two pointers, backtracking, topological sort — is more valuable than memorising hundreds of individual problems.</p>
<p>Aim for 3–5 problems per pattern, understand the template, then move on. A mentor who has been through the process can cut your prep time in half by pointing you directly to the patterns that appear most frequently.</p>

<h3>Phase 3: Behavioural and System Design (Weeks 11–14)</h3>
<p>Coding is only part of the evaluation. FAANG companies use the STAR method to assess leadership, conflict resolution, and ownership. Simultaneously, senior roles require system design: design Twitter, design a URL shortener, design a distributed cache.</p>
<p>Practice out loud. Mock interviews — especially with an experienced mentor who has conducted FAANG loops themselves — are the single highest-leverage activity in this phase.</p>

<h3>The Mentor Advantage</h3>
<p>A mentor who has cleared FAANG interviews gives you something no course can: real feedback on your approach, not just your answer. They catch bad habits early — over-engineering, poor communication, jumping to code without clarifying requirements — before they cost you an offer.</p>
<p>Ready to start? <a href="/mentors">Find a FAANG-experienced mentor on MentF.</a></p>
HTML,
                'is_published' => true,
                'published_at' => now()->subDays(30),
            ],
            [
                'title'   => 'From Fresher to Senior Engineer in 3 Years: What Actually Works',
                'slug'    => 'fresher-to-senior-engineer-in-3-years',
                'excerpt' => 'Most engineers take 7–10 years to reach a senior role. A focused few do it in 3. The difference is almost always intentional skill-building guided by the right people.',
                'content' => <<<'HTML'
<p>The traditional career ladder in Indian tech companies assumes 7–10 years to reach a senior engineering role. But at product companies, high-growth startups, and global firms, some engineers make the jump in three years or less. What separates them?</p>

<h3>1. They Build Depth, Not Just Breadth</h3>
<p>Junior engineers often hop between technologies — React one month, Go the next, then dabbling in ML. Senior engineers are known for something. Pick one domain and become the go-to person for it on your team.</p>

<h3>2. They Take Ownership of Outcomes, Not Just Tasks</h3>
<p>Junior engineers close tickets. Senior engineers close problems. The difference is asking "why is this the right thing to build?" before asking "how do I build it?" Taking ownership means tracking the impact of your work after it ships, not just filing the PR.</p>

<h3>3. They Invest in Communication Early</h3>
<p>Writing clear design docs, giving well-structured code reviews, and presenting technical trade-offs to non-engineers are skills that most engineers neglect until they are already trying to get promoted. Start building them in year one.</p>

<h3>4. They Find a Mentor in Year One, Not Year Five</h3>
<p>The engineers who accelerate fastest almost universally point to a mentor — a senior colleague, a manager, or an external coach — who gave them honest feedback, stretch opportunities, and a map of the invisible rules of career progression.</p>

<h3>The 90-Day Plan</h3>
<ul>
<li><strong>Month 1:</strong> Identify your depth domain and have an explicit conversation with your manager about what "senior" looks like at your company</li>
<li><strong>Month 2:</strong> Volunteer for one project that is above your current level</li>
<li><strong>Month 3:</strong> Start mentorship sessions focused on the specific gaps between where you are and where you want to be</li>
</ul>
<p><a href="/mentors">Connect with a senior engineer mentor on MentF</a> to map out your personalised path.</p>
HTML,
                'is_published' => true,
                'published_at' => now()->subDays(27),
            ],
            [
                'title'   => "The Startup Founder's Guide to Finding a Business Mentor",
                'slug'    => 'startup-founder-guide-to-business-mentor',
                'excerpt' => 'Building a startup without a mentor is like navigating a new city without a map. Here is how founders find, approach, and get the most out of mentorship relationships.',
                'content' => <<<'HTML'
<p>Over 90% of startups fail within five years. The founders who beat those odds rarely do it alone — they have advisors, investors, and mentors who have walked the path before them and can flag the landmines before it is too late.</p>

<h3>Why Founders Need Mentors Differently</h3>
<p>Employee-mentorship is about skill development. Founder-mentorship is about judgement. As a founder, you will make dozens of irreversible decisions every month — on co-founders, hiring, fundraising, pricing, pivots. A mentor who has built and exited a company helps you ask better questions before you commit.</p>

<h3>What to Look for in a Startup Mentor</h3>
<ul>
<li><strong>Relevant context:</strong> A mentor who has built in your exact space will give you contacts and shortcuts, not just frameworks</li>
<li><strong>Honest, not cheerful:</strong> The most valuable mentors tell you when you are wrong, not just celebrate your wins</li>
<li><strong>Network density:</strong> A mentor who can make two introductions — to a potential customer and to a relevant investor — is worth more than a year of generic advice</li>
</ul>

<h3>How to Approach a Mentor as a Founder</h3>
<p>Cold emails work when they are specific. "I would love to pick your brain" is forgettable. "I am building X for Y persona, we have hit Z early traction, and I have a specific question about scaling from 10L to 1Cr ARR" is actionable and shows you have done your research.</p>

<h3>Structuring Your Mentorship Sessions</h3>
<p>Come with three things: your biggest current challenge, what you have already tried, and the specific decision you need to make. Mentors are busy. The founders who get the most value are the ones who respect time and come prepared.</p>
<p><a href="/mentors">Find a startup mentor on MentF</a> and start your first structured session this week.</p>
HTML,
                'is_published' => true,
                'published_at' => now()->subDays(24),
            ],
            [
                'title'   => 'Top 8 Skills Hiring Managers Will Pay a Premium For in 2025',
                'slug'    => 'top-skills-hiring-managers-pay-premium-2025',
                'excerpt' => 'The job market is shifting fast. These eight skills are creating the biggest salary gaps between candidates — and a mentor can help you build them faster than any course.',
                'content' => <<<'HTML'
<p>LinkedIn, Naukri, and global hiring reports consistently show that certain skills command a 30–70% salary premium over the average. Here are the eight that are generating the most hiring demand in 2025.</p>

<h3>1. AI/ML Engineering (Not Just Prompting)</h3>
<p>The market is flooded with people who can use ChatGPT. What is scarce — and highly paid — is engineers who can fine-tune models, build RAG pipelines, and evaluate LLM outputs in production systems.</p>

<h3>2. Cloud Architecture (AWS / GCP / Azure)</h3>
<p>Senior cloud architects in India command ₹40–80L+ packages. The path is not just passing certifications but demonstrating real multi-cloud, cost-optimised architectures in production.</p>

<h3>3. Product Management with Technical Depth</h3>
<p>PMs who can read code, write SQL, and speak credibly with engineering teams earn 25–40% more than pure business-side PMs. This is a gap a technical mentor can help you close in 3–6 months.</p>

<h3>4. Data Engineering</h3>
<p>As companies drown in data, people who can build reliable pipelines (dbt, Spark, Airflow, Kafka) are becoming as scarce as good backend engineers. Median CTC for senior data engineers at Indian product companies crossed ₹35L in 2024.</p>

<h3>5. Cybersecurity</h3>
<p>India has a severe shortage of security professionals. Application security, cloud security, and SOC analysis roles are sitting unfilled for months. Entry-level salaries start at ₹8–12L; senior specialists earn ₹40L+.</p>

<h3>6. Full-Stack with React + Node or Go</h3>
<p>The T-shaped engineer who can own both frontend and backend with modern stacks remains one of the most hirable profiles at startups and mid-sized product companies.</p>

<h3>7. Technical Writing and Developer Relations</h3>
<p>DevRel roles at global companies pay $80–150K. Indian engineers with strong English writing skills and technical depth are underrepresented in this space — creating a real arbitrage opportunity.</p>

<h3>8. Negotiation and Salary Benchmarking</h3>
<p>Most Indian engineers leave 20–40% salary on the table at every job change because they do not negotiate. A mentor who has coached dozens of candidates on offer negotiation can directly add lakhs to your CTC.</p>

<p><a href="/packages">Browse learning packages on MentF</a> to find structured paths for any of these skills.</p>
HTML,
                'is_published' => true,
                'published_at' => now()->subDays(21),
            ],
            [
                'title'   => 'How to Get the Most Out of Every Mentorship Session',
                'slug'    => 'get-most-out-of-mentorship-sessions',
                'excerpt' => 'Most mentees waste their sessions with vague questions and no follow-through. Here is a simple system to make every hour with your mentor count.',
                'content' => <<<'HTML'
<p>A mentorship session is not a lecture. It is a conversation between someone who has navigated a path and someone who is about to. The quality of the output depends almost entirely on the quality of the input — and that is the mentee's responsibility.</p>

<h3>Before the Session: Prepare in Writing</h3>
<p>Send your mentor a brief message 24–48 hours before your session. Include:</p>
<ul>
<li>What you worked on since the last session</li>
<li>What went well and what got stuck</li>
<li>Your top 1–2 questions for this session</li>
</ul>
<p>This shifts the session from catch-up mode to problem-solving mode immediately.</p>

<h3>During the Session: Be Specific, Not General</h3>
<p>"How do I get better at system design?" is a bad question. "I struggled to explain database sharding trade-offs in my last mock interview — can we work through the canonical example together?" is an excellent question. Specific problems yield specific, actionable answers.</p>
<p>Take notes in real time. Your memory of a 60-minute conversation will fade to 20% within 24 hours.</p>

<h3>The One Question Rule</h3>
<p>At the end of every session, ask one closing question: "Based on what we covered today, what is the one thing you would prioritise if you were in my position?" This often surfaces the mentor's real take — the thing they have been thinking but did not say explicitly.</p>

<h3>After the Session: The 48-Hour Action Window</h3>
<p>The value of a mentorship session decays rapidly if you do not act on it. Within 48 hours: complete the top action item, update your notes with your reflections, and drop a one-line message to your mentor with what you did. This accountability loop is what separates mentees who grow fast from those who plateau.</p>

<h3>A Word on Consistency</h3>
<p>One session a month over six months beats a single intensive day every time. Skill-building is cumulative. Regular sessions create accountability, momentum, and a feedback loop that compounds over time.</p>
<p><a href="/mentors">Find a mentor on MentF</a> and book your first session today.</p>
HTML,
                'is_published' => true,
                'published_at' => now()->subDays(18),
            ],
            [
                'title'   => 'Career Switch to Product Management: The Honest Guide for Engineers',
                'slug'    => 'career-switch-to-product-management-guide',
                'excerpt' => 'Thousands of engineers want to become product managers every year. Most fail the transition not because of skills — but because of strategy. Here is what actually works.',
                'content' => <<<'HTML'
<p>Product Management is one of the most sought-after career transitions for Indian software engineers. The appeal is obvious: broader impact, closer to business strategy, and often significantly higher compensation at senior levels. The reality of the transition, however, is more nuanced.</p>

<h3>Why Engineers Fail the PM Transition</h3>
<p>The most common failure mode is not a lack of product sense — it is the inability to stop engineering. Engineers who become PMs often default to technical solutioning when the role demands customer empathy, prioritisation trade-offs, and stakeholder alignment.</p>

<h3>The Two Paths</h3>
<p><strong>Internal transition:</strong> Moving from an engineering role to a PM role at your current company. This is the most reliable path — you have organisational context, relationships, and a proven track record.</p>
<p><strong>External transition:</strong> Applying directly to PM roles at other companies with your engineering background as your differentiator. This works best at product companies that explicitly value technical PMs (fintech, infrastructure, developer tools).</p>

<h3>What You Need to Build Before You Apply</h3>
<ul>
<li><strong>Product portfolio:</strong> 2–3 write-ups of product decisions you influenced or led, with data. Not features you built — decisions you drove.</li>
<li><strong>Customer interviews:</strong> Conduct 10+ structured customer discovery interviews and write up your findings. Most engineers have never done this.</li>
<li><strong>PM interview prep:</strong> Product sense, estimation, metrics, root cause analysis, and strategy questions are all distinct skill areas that require deliberate practice.</li>
</ul>

<h3>The Role of a PM Mentor</h3>
<p>A PM mentor who has successfully made the same transition can dramatically compress your learning curve. They can review your portfolio, run mock PM interviews, and most importantly, help you navigate the politics of an internal transition.</p>
<p><a href="/mentors">Find a Product Management mentor on MentF.</a></p>
HTML,
                'is_published' => true,
                'published_at' => now()->subDays(15),
            ],
            [
                'title'   => 'Building Your Personal Brand as a Tech Professional in India',
                'slug'    => 'building-personal-brand-tech-professional-india',
                'excerpt' => 'In a market of millions of engineers, the ones who get the best opportunities are not always the most skilled — they are the most visible. Here is how to build a brand that works.',
                'content' => <<<'HTML'
<p>India produces over 1.5 million engineering graduates a year. The supply of technically competent people is enormous. In this environment, personal brand is not vanity — it is a career moat. Engineers with strong online presence consistently receive better inbound opportunities and advance faster.</p>

<h3>LinkedIn: The Highest-ROI Platform for Indian Tech Professionals</h3>
<p>A well-optimised profile is table stakes. What actually moves the needle is consistent, thoughtful content — not generic motivational posts, but specific insights from your work.</p>
<p>Write about a problem you solved last week. Share a non-obvious lesson from a recent project. Document a technology decision with its trade-offs. This kind of content attracts hiring managers, collaborators, and potential mentors.</p>

<h3>The "Show Your Work" Principle</h3>
<p>The best personal brand builders in tech share process, not just outcomes. GitHub contributions, technical blog posts, open-source pull requests, and public talks all create evidence that your skills are real — worth ten times a line on a resume.</p>

<h3>Speaking and Writing: The Multipliers</h3>
<p>One well-researched blog post on a specific technical topic can bring more career value than a year of LinkedIn activity. A talk at a local tech meetup puts you in front of decision-makers who are actively looking for talent. Start small — a five-minute lightning talk at a community event — and build from there.</p>

<h3>How a Mentor Accelerates Brand Building</h3>
<p>A mentor who has built their own brand in your domain can give you something no content calendar can: credibility by association. Being introduced by a well-respected practitioner opens doors that cold applications cannot.</p>
<p>They can also give you honest feedback on your content before you publish — saving you from posts that would quietly damage your reputation rather than build it.</p>
<p><a href="/mentors">Work with a mentor on MentF to build your professional brand.</a></p>
HTML,
                'is_published' => true,
                'published_at' => now()->subDays(12),
            ],
            [
                'title'   => 'Data Science vs Machine Learning vs AI Engineering: Which Path Is Right for You?',
                'slug'    => 'data-science-vs-ml-vs-ai-engineering',
                'excerpt' => 'These three titles describe very different jobs with different salaries, day-to-day work, and career trajectories. Here is how to choose the right one for you.',
                'content' => <<<'HTML'
<p>The AI and data job market in India is booming — but the terminology is a minefield. "Data Scientist", "ML Engineer", and "AI Engineer" appear in job descriptions for roles that are sometimes identical and sometimes completely different. Before you invest months of preparation, understand what you are actually signing up for.</p>

<h3>Data Scientist</h3>
<p><strong>What they actually do:</strong> Analyse large datasets, build statistical models, and translate findings into business decisions. Heavy on Python, SQL, statistics, and data visualisation. Most of the day is data cleaning, exploratory analysis, and communicating insights to non-technical stakeholders.</p>
<p><strong>Salary range (India, 2025):</strong> ₹6L–₹35L depending on company and seniority</p>
<p><strong>Best for:</strong> People who enjoy the intersection of statistics, business strategy, and storytelling</p>

<h3>Machine Learning Engineer</h3>
<p><strong>What they actually do:</strong> Take models from research or experimentation into production systems. Strong software engineering background required. Responsibilities include feature engineering, model training pipelines, A/B testing infrastructure, and model monitoring.</p>
<p><strong>Salary range (India, 2025):</strong> ₹15L–₹60L at product companies</p>
<p><strong>Best for:</strong> Software engineers who want to specialise in ML systems, not just models</p>

<h3>AI Engineer (the emerging role)</h3>
<p><strong>What they actually do:</strong> Build applications on top of foundation models — LLMs, multimodal models, embedding systems. The stack includes prompt engineering, RAG architectures, vector databases, LLM evaluation frameworks, and agent systems.</p>
<p><strong>Salary range (India, 2025):</strong> ₹20L–₹80L+ at AI-first companies and global firms</p>
<p><strong>Best for:</strong> Engineers who want to build user-facing AI products quickly</p>

<h3>How to Choose</h3>
<ul>
<li>Strong in statistics and enjoy business context → Data Science</li>
<li>Strong software engineer curious about production ML systems → ML Engineering</li>
<li>Want to build products with the latest LLMs → AI Engineering</li>
</ul>
<p>The best way to validate your choice is to talk to someone actively working in each role. A mentor who does the job day-to-day will give you a more honest picture than any job description.</p>
<p><a href="/mentors">Find an AI/ML mentor on MentF</a> and get clarity on your path in a single session.</p>
HTML,
                'is_published' => true,
                'published_at' => now()->subDays(9),
            ],
            [
                'title'   => 'The Art of Asking Better Questions: How to Get More From Any Expert',
                'slug'    => 'art-of-asking-better-questions',
                'excerpt' => 'The quality of the answers you get from mentors, seniors, and subject matter experts is almost entirely determined by the quality of your questions. Here is how to ask better ones.',
                'content' => <<<'HTML'
<p>There is a skill that compounds faster than almost any technical ability — the ability to ask questions that unlock genuinely useful answers. Whether you are in a mentorship session, a job interview, a technical review, or a meeting with a senior leader, better questions change the conversation.</p>

<h3>Why Most Questions Are Weak</h3>
<p>Most people ask questions that are either too broad ("What advice do you have for me?"), too closed ("Is this approach good?"), or that telegraph the answer they want. None of these invite the expert to share what they actually know.</p>

<h3>The SPIN Framework for Mentorship Questions</h3>
<ul>
<li><strong>Situation:</strong> "Here is my current context — [brief description]"</li>
<li><strong>Problem:</strong> "The specific challenge I am facing is — [precise problem statement]"</li>
<li><strong>Implication:</strong> "If I get this wrong, the consequence is — [stakes]"</li>
<li><strong>Need:</strong> "What I am trying to decide is — [specific question]"</li>
</ul>
<p>This structure gives your mentor exactly what they need to give a targeted, high-value answer — and it shows that you have thought carefully about your situation, which builds trust.</p>

<h3>The "What Would You Do?" Question</h3>
<p>One of the highest-yield questions in any mentorship session: "If you were in my exact situation — knowing what you know now — what would you do?" This bypasses generic advice and invites the mentor to draw on their real experience and instincts.</p>

<h3>Follow-up Questions That Unlock Depth</h3>
<ul>
<li>"Can you give me an example of a time you faced something similar?"</li>
<li>"What would change your answer?"</li>
<li>"What am I not asking that I should be asking?"</li>
</ul>
<p>That last question is particularly powerful. Experts often hold back their most valuable insight because they assume you are not ready for it or it was not what you asked for.</p>
<p><a href="/mentors">Book a session with an expert mentor on MentF</a> and put these techniques to work immediately.</p>
HTML,
                'is_published' => true,
                'published_at' => now()->subDays(6),
            ],
            [
                'title'   => 'How to Negotiate Your Salary in India: A Step-by-Step Guide',
                'slug'    => 'how-to-negotiate-salary-india-guide',
                'excerpt' => 'Most Indian professionals accept the first offer they receive. That single habit costs them lakhs every year. Here is the exact negotiation framework that works in 2025.',
                'content' => <<<'HTML'
<p>Salary negotiation is one of the highest-return-on-time activities in a professional career. A successful negotiation takes 20 minutes and can add ₹3–10L to your annual package — and because future raises are usually percentage-based, that gap compounds every year.</p>

<h3>Step 1: Know Your Market Value Before You Apply</h3>
<p>Your negotiation position is determined before the first interview. Research salaries using Levels.fyi (for product companies), AmbitionBox, Glassdoor, and — most powerfully — conversations with people currently in similar roles at the target company. A mentor in your target industry can give you accurate, current benchmarks that no website can match.</p>

<h3>Step 2: Never Give a Number First</h3>
<p>When asked for your expected CTC, deflect: "I am more interested in understanding the full scope of the role before discussing numbers — what is the budgeted range for this position?" Most recruiters will share a range if pressed. This gives you information without anchoring low.</p>

<h3>Step 3: The Offer Arrives — Wait 24 Hours</h3>
<p>Never accept on the spot. Thank the recruiter, express genuine enthusiasm, and ask for 24–48 hours to review. This is standard practice, not rudeness. Use that time to evaluate every component: base salary, variable pay, ESOPs, joining bonus, and benefits.</p>

<h3>Step 4: Counter With Confidence and Specificity</h3>
<p>The most effective counter-offer is specific and justified: "Based on my research and the market data for this role in [city], I was expecting ₹X. Given my [specific experience] directly relevant to [specific responsibility in the JD], would you be able to move to ₹Y?"</p>
<p>A concrete number with a concrete reason is far harder to dismiss than "I was expecting more."</p>

<h3>Step 5: Negotiate the Full Package</h3>
<p>If the base is firm, shift to other components — joining bonus, accelerated first review, additional ESOPs, remote work flexibility, or a training budget. HR often has more flexibility here than on base salary.</p>

<h3>The Mentor Role in Negotiation Prep</h3>
<p>A mentor who has hired or been hired at the companies you are targeting can tell you exactly what the actual salary bands are, which components are negotiable, and how to frame your counter without souring the relationship.</p>
<p><a href="/mentors">Work with a career mentor on MentF</a> to prepare for your next offer negotiation.</p>
HTML,
                'is_published' => true,
                'published_at' => now()->subDays(4),
            ],
            [
                'title'   => 'Preparing for Your First International Tech Role: What Indian Engineers Need to Know',
                'slug'    => 'preparing-for-international-tech-role-indian-engineers',
                'excerpt' => 'Landing a role in the US, UK, Canada, or Germany as an Indian engineer requires more than technical skills. Here is what actually sets the candidates apart who make it.',
                'content' => <<<'HTML'
<p>Indian engineers are among the most sought-after technology talent globally. Google, Microsoft, Amazon, and thousands of high-growth companies actively recruit from India. Yet the gap between a strong Indian engineer and a successful international hire is often not technical — it is preparation, communication, and process knowledge.</p>

<h3>Understanding the Difference in Interview Culture</h3>
<p>Interview styles vary significantly by country. In the US, behavioural interviews using the STAR method carry enormous weight. In Germany, technical depth and written communication are valued over personality fit. In the UK, case studies and open-ended problem discussions are common at senior levels. Knowing the culture before you interview is a significant advantage.</p>

<h3>Visa Pathways: Know Your Options</h3>
<ul>
<li><strong>USA:</strong> H-1B (lottery-based, employer-sponsored), L-1 (intracompany transfer — a popular path for engineers in India offices of US companies), O-1 (extraordinary ability)</li>
<li><strong>Canada:</strong> Express Entry and the Global Talent Stream (fast-tracked for tech roles — as fast as 2 weeks). One of the most accessible international tech markets for Indian engineers.</li>
<li><strong>Germany:</strong> EU Blue Card. Germany has a skills shortage in tech and actively recruits non-EU engineers. Many Berlin-based companies operate entirely in English.</li>
<li><strong>UK:</strong> Global Talent Visa (for exceptional talent) and Skilled Worker Visa (employer-sponsored)</li>
</ul>

<h3>What Sets the Candidates Apart</h3>
<ol>
<li>They target companies that already have a strong India hiring pipeline — lower activation energy and established transfer paths</li>
<li>They invest in communication skills — not accent elimination, but clarity, structure, and conciseness in written and verbal communication</li>
<li>They work with a mentor who has made the same transition — someone who can tell them what the realistic timeline is, which companies are worth targeting, and how to avoid the common application mistakes</li>
</ol>

<h3>The Realistic Timeline</h3>
<p>For most Indian engineers targeting a first international role, 12–18 months of focused preparation is realistic. A mentor who has made this journey can compress that timeline significantly by eliminating the trial-and-error phase.</p>
<p><a href="/mentors">Find a mentor on MentF who has successfully transitioned to an international tech role.</a></p>
HTML,
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title'   => 'Why Most Online Courses Do Not Change Careers (And What Does)',
                'slug'    => 'why-online-courses-dont-change-careers',
                'excerpt' => 'The e-learning market sold us the idea that the right course leads to the right job. The data disagrees. Here is what career changers who actually succeed have in common.',
                'content' => <<<'HTML'
<p>India's online education market is worth over $6 billion. Millions of professionals have bought courses on Python, cloud computing, product management, digital marketing, and data science. Yet the conversion from "course completed" to "career changed" remains stubbornly low.</p>
<p>This is not a failure of individual effort. It is a structural problem with how most online courses are designed.</p>

<h3>The Passive Learning Trap</h3>
<p>Watching a video or reading a module feels like learning because your brain is engaged. But retention without application decays to near-zero within two weeks. Most courses are designed to sell the feeling of learning, not to produce the behavioural change that makes careers move.</p>
<p>The research on skill acquisition is unambiguous: deliberate practice with feedback beats passive consumption by a factor of 10 or more.</p>

<h3>The Portfolio Gap</h3>
<p>Even when a course includes projects, those projects are almost never the thing that gets someone hired. Hiring managers have seen thousands of Titanic survival prediction models and to-do list apps. What actually differentiates candidates is work that solves a real problem — and that kind of work almost never comes from a course curriculum.</p>

<h3>The Missing Feedback Loop</h3>
<p>The highest-value thing a teacher provides is not information — it is feedback. Knowing what you got wrong, why, and how to fix it. Courses at scale cannot provide this. A mentor can.</p>
<p>When a senior data engineer tells you that your pipeline design has a fan-out problem that will fail at 10x load, you learn something that 50 hours of course video would never teach you.</p>

<h3>What Actually Changes Careers</h3>
<ol>
<li><strong>A portfolio of real, original work</strong> — not tutorial projects</li>
<li><strong>A network in the target domain</strong> — most jobs are not publicly listed</li>
<li><strong>Guided practice with feedback</strong> — from someone who has done the job</li>
<li><strong>Interview preparation specific to the role and company</strong></li>
</ol>
<p>Courses can be a useful starting point. But they are the first 20% of the journey, not the whole path.</p>
<p><a href="/packages">Browse structured mentorship packages on MentF</a> — built to close the gap between learning and doing.</p>
HTML,
                'is_published' => true,
                'published_at' => now()->subDays(1),
            ],
        ];

        foreach ($posts as &$post) {
            $post['created_at'] = $post['published_at'];
            $post['updated_at'] = $post['published_at'];
        }

        DB::table('blog_posts')->insertOrIgnore($posts);
    }

    public function down(): void
    {
        $slugs = [
            'how-to-crack-faang-interviews',
            'fresher-to-senior-engineer-in-3-years',
            'startup-founder-guide-to-business-mentor',
            'top-skills-hiring-managers-pay-premium-2025',
            'get-most-out-of-mentorship-sessions',
            'career-switch-to-product-management-guide',
            'building-personal-brand-tech-professional-india',
            'data-science-vs-ml-vs-ai-engineering',
            'art-of-asking-better-questions',
            'how-to-negotiate-salary-india-guide',
            'preparing-for-international-tech-role-indian-engineers',
            'why-online-courses-dont-change-careers',
        ];

        DB::table('blog_posts')->whereIn('slug', $slugs)->delete();
    }
};
