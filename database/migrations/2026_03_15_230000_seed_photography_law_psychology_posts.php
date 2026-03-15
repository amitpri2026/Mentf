<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $posts = [

            // ── Photography ──────────────────────────────────────────────────

            [
                'title'   => 'Mastering Natural Light in Portrait Photography',
                'slug'    => 'mastering-natural-light-portrait-photography',
                'excerpt' => 'The most expensive studio light cannot beat a well-understood window. Here is how to read, shape, and use natural light to take stunning portraits with any camera.',
                'content' => <<<'HTML'
<p>Natural light is the most democratic tool in photography — it costs nothing, exists everywhere, and in the right hands produces images that no artificial setup can replicate. Yet most beginners either shoot in harsh midday sun or avoid outdoor shooting entirely. Learning to see and use natural light is the single highest-leverage skill a portrait photographer can develop.</p>

<h3>The Golden Hours: Your Best Friend</h3>
<p>The hour after sunrise and the hour before sunset — the "golden hours" — produce warm, directional light with long shadows and a flattering quality that makes any subject look good. The low angle of the sun wraps light around faces softly, reducing the hard shadows you get from overhead midday light.</p>
<p>If you can only shoot portraits during one time of day, choose the golden hour. The colours, the soft gradients, and the emotional warmth of the light are almost impossible to recreate in post-processing.</p>

<h3>Window Light: The Indoor Studio You Already Have</h3>
<p>A large window on an overcast day is essentially a giant softbox. The technique is simple:</p>
<ul>
<li>Position your subject at 45° to the window for classic Rembrandt lighting</li>
<li>Use a white foam board or reflector on the shadow side to fill in harsh shadows</li>
<li>Back your subject slightly away from the window — close proximity creates high contrast, distance creates softer, more even light</li>
</ul>
<p>North-facing windows are ideal because they never receive direct sun — just soft, consistent diffused light throughout the day.</p>

<h3>Overcast Days Are Not Bad — They Are Diffused</h3>
<p>Clouds act as a natural diffuser, scattering harsh sunlight into soft, even illumination that wraps around your subject from multiple directions. Shadows are minimal, skin tones render beautifully, and you can shoot any time without worrying about the sun angle.</p>
<p>The limitation is that overcast light can feel flat. Compensate by adding depth through composition — interesting backgrounds, leading lines, framing elements.</p>

<h3>Backlight and Rim Light</h3>
<p>Placing your subject between you and the light source creates a rim of light around their silhouette — particularly beautiful with hair. Expose for the subject's face (not the bright background) and you will get a glowing rim effect that separates your subject from the background naturally.</p>
<p>This technique works especially well at sunset when the warm light creates a golden rim that is almost impossible to replicate artificially.</p>

<h3>Practical Exercise</h3>
<p>Spend one hour photographing the same subject every 30 minutes throughout the day. Compare the results. You will viscerally understand how light quality, direction, and colour temperature change — and that understanding will permanently change how you see and plan every shoot.</p>

<p>Want to accelerate your photography learning with personalised guidance? <a href="/mentors">Find a photography mentor on MentF.</a></p>
HTML,
                'is_published' => true,
                'published_at' => now()->subDays(20),
            ],

            [
                'title'   => 'The 5 Composition Rules Every Photographer Should Know (and When to Break Them)',
                'slug'    => 'composition-rules-every-photographer-should-know',
                'excerpt' => 'Composition is the grammar of visual language. Master these five rules and your images will communicate with intention — then learn when to break them for even greater impact.',
                'content' => <<<'HTML'
<p>Technical exposure is learnable in a day. Composition takes years to internalise — and it is what separates technically correct images from genuinely compelling ones. Here are the five rules that form the foundation of strong visual composition.</p>

<h3>1. Rule of Thirds</h3>
<p>Divide your frame into a 3×3 grid. Place your primary subject along the gridlines — or better, at one of the four intersection points (called "power points"). This creates visual tension and balance that centred subjects rarely produce.</p>
<p><strong>When to break it:</strong> Centred compositions with strong symmetry — reflections, architectural details, formal portraits — often benefit from a deliberate centred placement that feels powerful rather than static.</p>

<h3>2. Leading Lines</h3>
<p>Roads, fences, rivers, stairways, and shadows all create lines that guide the viewer's eye through the frame. Strong leading lines that point toward your subject create depth and draw attention precisely where you want it.</p>
<p><strong>When to break it:</strong> Lines that lead out of the frame rather than into it can create a sense of departure or longing — useful for emotional storytelling images.</p>

<h3>3. Framing</h3>
<p>Use natural elements — doorways, arches, tree branches, tunnels — to create a frame within your frame. This adds depth, focuses attention on your subject, and creates a sense of context and environment.</p>
<p>The frame does not need to be perfectly clean or complete. A partial arch or overhanging branch is enough to add dimension.</p>

<h3>4. Depth and Layers</h3>
<p>Strong images usually have three layers: a foreground, a midground subject, and a background. The foreground anchors the viewer in the scene and creates a sense of three-dimensionality that flat two-layer images lack.</p>
<p>This is why ground-level angles are so effective — they include the surface the subject is standing on as a foreground element, adding a dimension of depth.</p>

<h3>5. Negative Space</h3>
<p>Empty space is not wasted space — it is breath. A subject surrounded by clean negative space reads more powerfully than one competing with visual clutter. Negative space communicates isolation, simplicity, or scale depending on context.</p>
<p>Sky, still water, fog, and minimal walls all serve as excellent negative space. The key is that the emptiness should be intentional and clean, not accidental.</p>

<h3>The Real Lesson</h3>
<p>Rules exist to help you see. Once you can identify why a composition works, you can consciously break rules for emotional effect. The photographers whose work makes you feel something are almost always deliberately breaking at least one rule in each image.</p>

<p>Work with a photography mentor on MentF to get personalised feedback on your compositions. <a href="/mentors">Find a mentor.</a></p>
HTML,
                'is_published' => true,
                'published_at' => now()->subDays(14),
            ],

            [
                'title'   => 'From Smartphone to DSLR: A Practical Beginner\'s Guide to Photography',
                'slug'    => 'smartphone-to-dslr-beginners-guide-photography',
                'excerpt' => 'Buying a DSLR or mirrorless camera is exciting — and immediately overwhelming. Here is the no-jargon guide to getting great images from day one without drowning in settings.',
                'content' => <<<'HTML'
<p>The most common mistake new DSLR owners make is shooting in full Auto mode for six months and wondering why their images look the same as their phone. The camera is a tool — understanding three core concepts will immediately transform your images.</p>

<h3>The Exposure Triangle: The Only Technical Concept You Need</h3>
<p>Every photograph is an exposure — the amount of light that reaches your sensor. Three settings control this, and they trade off against each other:</p>
<ul>
<li><strong>Aperture (f-number):</strong> Controls how much light the lens allows in. Low f-numbers (f/1.8, f/2.8) let in more light and blur the background. High f-numbers (f/11, f/16) let in less light but keep more of the scene in focus.</li>
<li><strong>Shutter Speed:</strong> How long the sensor is exposed. Fast speeds (1/500s, 1/1000s) freeze motion. Slow speeds (1/30s, 1s) blur motion and allow more light in low conditions.</li>
<li><strong>ISO:</strong> The sensor sensitivity. Low ISO (100, 200) produces clean images. High ISO (3200, 6400) allows shooting in dark conditions but adds grain.</li>
</ul>
<p>Start with Aperture Priority mode (A or Av on the dial). You control the aperture, the camera handles shutter speed. This gives you creative control over background blur without worrying about exposure.</p>

<h3>Your First Week: Aperture Exploration</h3>
<p>Spend your first week shooting the same subject at different apertures — f/1.8, f/4, f/8, f/16. Look at the background blur (bokeh) and the depth of field (how much of the scene is sharp). This single exercise will teach you more about aperture than any YouTube video.</p>

<h3>Autofocus: Stop Fighting It, Start Understanding It</h3>
<p>Modern autofocus systems are excellent. For portraits, use face/eye detection if your camera has it — it locks on to eyes with remarkable precision. For moving subjects, use continuous autofocus (AF-C or AI Servo). For static subjects in complex scenes, use single-point AF and move the focus point over your subject.</p>

<h3>The Most Important Setting: RAW vs JPEG</h3>
<p>Switch to RAW format immediately. RAW files retain all the data the sensor captured — you can fix exposure, white balance, and colour in post without quality loss. JPEGs are processed in-camera and discard a large portion of that data permanently.</p>
<p>Yes, you will need Lightroom or similar software. The investment in learning basic post-processing is the second-highest-leverage thing you can do as a beginner.</p>

<h3>Gear Is Not Your Limitation</h3>
<p>Any entry-level DSLR or mirrorless camera from the last five years will produce images limited entirely by the photographer, not the equipment. Before upgrading, ask yourself: would a mentor looking at my images tell me the camera is the problem? Almost certainly not.</p>

<p>Connect with an experienced photography mentor on MentF for hands-on feedback and structured guidance. <a href="/mentors">Find a photography mentor.</a></p>
HTML,
                'is_published' => true,
                'published_at' => now()->subDays(8),
            ],

            // ── Law ──────────────────────────────────────────────────────────

            [
                'title'   => 'Your Legal Rights as a Freelancer in India: What You Must Know',
                'slug'    => 'legal-rights-freelancer-india',
                'excerpt' => 'Freelancers in India have fewer default protections than employees — but you have more legal tools than you probably know. Here is what to enforce and how.',
                'content' => <<<'HTML'
<p>India has over 15 million freelancers — one of the largest freelance workforces in the world. Yet most operate without contracts, without awareness of their rights, and without protection when clients delay or default on payments. Here is the legal landscape you need to understand.</p>

<h3>The Contract Is Everything</h3>
<p>As a freelancer, you are an independent contractor. Your relationship with every client is governed by contract law under the Indian Contract Act, 1872. This means that a written contract — even a simple email chain confirming deliverables, timelines, and payment terms — is legally enforceable.</p>
<p>Without a contract, you are relying on goodwill. Get everything in writing, always. A good contract should specify:</p>
<ul>
<li>Scope of work (what is included and explicitly what is not)</li>
<li>Payment terms (amount, due date, late payment penalty)</li>
<li>Intellectual property ownership (who owns the deliverables)</li>
<li>Revision limits</li>
<li>Termination clause (how either party can exit)</li>
</ul>

<h3>Getting Paid: Your Legal Options When a Client Defaults</h3>
<p>When a client refuses to pay for completed work, you have legal recourse:</p>
<ul>
<li><strong>Legal notice:</strong> A formal notice from a lawyer demanding payment, citing the contract. This resolves 70%+ of payment disputes without going to court — most clients do not want legal trouble.</li>
<li><strong>Consumer Forum:</strong> If the amount is under ₹1 crore, the Consumer Disputes Redressal Commission is a low-cost, relatively fast option.</li>
<li><strong>Civil suit:</strong> For larger amounts, a money recovery suit in civil court. Slower, but effective for significant sums.</li>
<li><strong>MSME Samadhaan:</strong> If you are registered as an MSME, you can file on the government portal for delayed payments. Large companies are legally required to pay MSMEs within 45 days.</li>
</ul>

<h3>Intellectual Property: Who Owns Your Work?</h3>
<p>Under the Copyright Act, 1957, the creator owns the copyright by default unless a written agreement transfers it to the client. This means that if you write code, design a logo, or produce content without a contract specifying IP transfer, you retain ownership — even after being paid.</p>
<p>Most clients want full ownership. A licence grant or IP assignment clause in the contract handles this cleanly. Just make sure you are compensated appropriately for a full IP transfer.</p>

<h3>GST and Tax Compliance</h3>
<p>Freelancers with annual revenue over ₹20 lakhs are required to register for GST. International clients (exports of services) are zero-rated under GST — but you still need to file returns. Keep proper invoices for every payment and consider a CA who specialises in freelancers — the cost is worth it.</p>

<h3>When to Consult a Lawyer</h3>
<p>Before signing any agreement that is longer than two pages, involves significant money, or requires exclusivity or non-compete clauses, spend ₹2,000–5,000 on a one-hour consultation with a contracts lawyer. This is insurance against expensive problems.</p>

<p>Find a legal mentor on MentF who can help you build compliant freelance practices from day one. <a href="/mentors">Connect with a legal mentor.</a></p>
HTML,
                'is_published' => true,
                'published_at' => now()->subDays(17),
            ],

            [
                'title'   => 'Understanding Your Employment Contract: 7 Clauses Every Professional Must Read',
                'slug'    => 'understanding-employment-contract-clauses-india',
                'excerpt' => 'Most people sign employment contracts without reading them. Some of those clauses will bind you for years after you leave. Here is what to scrutinise before you sign.',
                'content' => <<<'HTML'
<p>An employment contract is a legal document that governs your relationship with an employer — not just while you are there, but often for years after you leave. Yet most employees spend more time reading restaurant menus than employment agreements. Here are the seven clauses that matter most.</p>

<h3>1. Notice Period and Recovery</h3>
<p>Indian employment contracts frequently have notice periods of 30–90 days. Some contracts allow "notice buy-out" — your employer can pay you in lieu of notice. Pay close attention to who can trigger this and whether the buy-out is mandatory or at the employer's discretion.</p>
<p>Also check if there is a notice period recovery clause — meaning if you leave earlier than the notice period, the company can deduct salary for the remaining days. This is enforceable in most Indian courts.</p>

<h3>2. Non-Compete Clause</h3>
<p>Many Indian IT contracts include non-compete clauses that restrict you from joining competitors for 6–24 months after leaving. The good news: Indian courts have consistently held that post-employment non-compete restrictions are void and unenforceable under Section 27 of the Indian Contract Act, as they restrict your right to earn a livelihood.</p>
<p>You can generally ignore post-employment non-competes. However, non-compete restrictions during employment are enforceable.</p>

<h3>3. Non-Solicitation Clause</h3>
<p>Unlike non-competes, non-solicitation clauses — which prevent you from poaching clients or colleagues after leaving — are generally enforceable in India if they are reasonable in scope and duration. Read these carefully, particularly if you plan to start your own practice or join a startup that might target your former employer's clients.</p>

<h3>4. Intellectual Property Assignment</h3>
<p>Most employment contracts assign all IP you create during employment to the company — including work done on personal time if it relates to the company's business. Some contracts go further and assign IP created using company resources regardless of business relevance.</p>
<p>If you have side projects, open-source contributions, or creative work, understand whether your contract affects them — and negotiate explicit carve-outs before signing.</p>

<h3>5. Confidentiality Obligations</h3>
<p>Confidentiality clauses are enforceable and can extend indefinitely. They cover client information, technical details, financial data, and internal processes. Violating confidentiality can result in both civil and criminal liability.</p>
<p>This is not a clause to push back on — it is a clause to understand deeply so you know what you can and cannot discuss or take with you when you leave.</p>

<h3>6. Variable Pay and Bonus Structure</h3>
<p>Variable pay (performance bonus, annual incentive) is often stated as "up to X% of fixed salary at company's discretion." This language means the company has no legal obligation to pay it. Negotiating for a specific guaranteed minimum or a transparent formula is always preferable.</p>

<h3>7. Probation and Confirmation</h3>
<p>During probation, many contracts allow the employer to terminate with little or no notice, or with reduced notice. Your employment protections under the Industrial Disputes Act may not fully apply during probation. Know how long your probation period is and what triggers confirmation.</p>

<p>A legal mentor on MentF can walk you through your specific contract and flag clauses that need attention or negotiation. <a href="/mentors">Find a legal mentor.</a></p>
HTML,
                'is_published' => true,
                'published_at' => now()->subDays(11),
            ],

            [
                'title'   => 'Intellectual Property Basics Every Creator and Entrepreneur Needs to Know',
                'slug'    => 'intellectual-property-basics-creators-entrepreneurs-india',
                'excerpt' => 'Copyright, trademark, patent — what do they protect, how do you get them, and how much do they cost? A plain-language guide to IP for Indian creators and founders.',
                'content' => <<<'HTML'
<p>Intellectual Property (IP) is the legal framework that lets creators and businesses own and profit from their ideas, creative works, and innovations. Getting IP right early is far cheaper than fixing IP problems later. Here is what you need to know.</p>

<h3>Copyright: What It Protects and What It Does Not</h3>
<p>Copyright protects original creative works — writing, music, software code, artwork, photographs, and films — the moment they are created and fixed in a tangible form. In India, copyright lasts for the creator's lifetime plus 60 years.</p>
<p><strong>What you get automatically:</strong> Copyright in India arises automatically on creation. You do not need to register.</p>
<p><strong>Why register anyway:</strong> Registration under the Copyright Act, 1957 creates a legal presumption of ownership — useful if you need to enforce your rights in court. The process costs around ₹500 per work and takes 2–3 months.</p>
<p><strong>What copyright does NOT protect:</strong> Ideas, concepts, facts, titles, names, and slogans. Only the specific expression of an idea is protected, not the idea itself.</p>

<h3>Trademark: Protecting Your Brand</h3>
<p>A trademark protects brand identifiers — your business name, logo, tagline, or even distinctive colours and sounds — in connection with specific goods or services.</p>
<p><strong>Why it matters:</strong> Without a trademark, anyone can use a similar name in your industry. With one, you have the legal right to prevent confusingly similar use and to take down infringing businesses.</p>
<p><strong>The process:</strong> File an application with the Trade Marks Registry. The process takes 18–24 months for full registration; however, you get TM rights (the right to use the ™ symbol) immediately on filing. Basic filing fees start at ₹4,500 per class for individuals and small businesses.</p>
<p><strong>Important:</strong> Do a trademark search before naming your business. Launching a brand only to receive a cease-and-desist letter is an expensive and avoidable problem.</p>

<h3>Patent: Protecting Inventions</h3>
<p>A patent protects inventions — novel, useful, and non-obvious technical solutions to problems. In India, patents are governed by the Patents Act, 1970 and last for 20 years from the filing date.</p>
<p><strong>What can be patented:</strong> Products, processes, and technical methods. Software is not directly patentable in India, though software with a technical effect or hardware component sometimes qualifies.</p>
<p><strong>The cost:</strong> Filing a patent application in India costs ₹1,600–16,000 in government fees depending on applicant type, plus significant attorney fees for drafting. A full patent prosecution takes 3–7 years.</p>
<p><strong>When to file:</strong> File before disclosing your invention publicly. Public disclosure before filing destroys novelty in most jurisdictions.</p>

<h3>Trade Secrets: Protection Without Registration</h3>
<p>Some IP is best protected as a trade secret — kept confidential rather than disclosed through patent or copyright registration. Algorithms, formulas, customer lists, and pricing strategies are common trade secrets.</p>
<p>Trade secret protection depends entirely on your confidentiality practices: NDAs with employees and contractors, access controls, and clear internal policies about what is confidential.</p>

<h3>Practical Advice for Founders and Creators</h3>
<ol>
<li>Register your brand as a trademark before you invest significantly in marketing</li>
<li>Use written IP assignment agreements with every contractor and employee</li>
<li>Register copyright for your most commercially important creative works</li>
<li>Consult an IP attorney before making any public disclosures about your core invention</li>
</ol>

<p>Work with a legal mentor on MentF who specialises in IP for startups and creators. <a href="/mentors">Find an IP mentor.</a></p>
HTML,
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],

            // ── Psychology ───────────────────────────────────────────────────

            [
                'title'   => 'The Science of Habit Formation: How to Build Skills That Actually Stick',
                'slug'    => 'science-of-habit-formation-build-skills-that-stick',
                'excerpt' => 'You cannot rely on motivation to build skills — motivation fluctuates, habits persist. Here is what the science says about forming the habits that create lasting expertise.',
                'content' => <<<'HTML'
<p>Every expert was once a beginner who kept showing up. The difference between the person who learns a new skill and the person who abandons it after two weeks is rarely talent — it is the architecture of their practice habits.</p>

<h3>The Habit Loop: Cue, Routine, Reward</h3>
<p>Neuroscientist Charles Duhigg popularised the habit loop model: every habit has three components:</p>
<ul>
<li><strong>Cue:</strong> The trigger that initiates the behaviour (a time, location, emotion, or preceding action)</li>
<li><strong>Routine:</strong> The behaviour itself</li>
<li><strong>Reward:</strong> The positive signal that reinforces the behaviour and makes the brain want to repeat it</li>
</ul>
<p>To build a new skill habit, design all three deliberately rather than hoping they emerge naturally. "I will study Python at 7pm every weekday (cue: time), for 45 minutes (routine), and mark my progress in a habit tracker (reward)" is a designed habit. "I will study when I feel like it" is a wish.</p>

<h3>Temptation Bundling</h3>
<p>Behavioural scientist Katy Milkman found that pairing a behaviour you want to do with something you enjoy dramatically increases follow-through. Allow yourself to listen to a favourite podcast or playlist only while doing your skill practice. The enjoyable activity becomes the reward that makes the habit sticky.</p>

<h3>The 2-Minute Rule</h3>
<p>When starting a new habit, make the initial version take less than 2 minutes. Not "practice guitar for 30 minutes" but "pick up the guitar." Not "run 5km" but "put on running shoes."</p>
<p>This sounds trivially small — but it works because starting is the hardest part. Once you have picked up the guitar, you will almost always play for longer than 2 minutes. The 2-minute rule eliminates the activation energy barrier.</p>

<h3>Implementation Intentions</h3>
<p>Research consistently shows that people who plan the specific when and where of a new behaviour are 2–3x more likely to follow through than those who just state the intention. "I will practice Spanish at 6:30am in the kitchen before breakfast" is an implementation intention. "I will practice Spanish more often" is not.</p>

<h3>The Role of Identity</h3>
<p>James Clear argues in Atomic Habits that the most durable habits are ones that align with your identity — not what you want to achieve, but who you believe you are. "I am a photographer who shoots every day" sustains practice more reliably than "I want to get better at photography."</p>
<p>Every time you act in line with the identity you want to build, you cast a vote for that identity. The habit is the vote-casting mechanism.</p>

<h3>Why Mentorship Accelerates Habit Formation</h3>
<p>External accountability is one of the most powerful forces in habit formation. When you have a mentor who will ask you next week what you practised, the psychological cost of skipping rises dramatically. This is not about fear — it is about social commitment, which our brains treat as a much stronger motivator than private intention.</p>

<p>Find a mentor on MentF who will provide the accountability structure your learning habits need. <a href="/mentors">Browse mentors.</a></p>
HTML,
                'is_published' => true,
                'published_at' => now()->subDays(16),
            ],

            [
                'title'   => 'Cognitive Biases That Sabotage Your Career Decisions (And How to Counter Them)',
                'slug'    => 'cognitive-biases-sabotage-career-decisions',
                'excerpt' => 'Your brain is not wired for optimal career decisions — it is wired for survival and social acceptance. Here are the biases that cost professionals the most, and how to think around them.',
                'content' => <<<'HTML'
<p>Behavioural economics has documented over 180 cognitive biases — systematic errors in human thinking that cause predictable, irrational decisions. Several of these are especially damaging in the context of career planning, job changes, and skill development. Knowing them is the first step to countering them.</p>

<h3>Sunk Cost Fallacy</h3>
<p>The tendency to continue investing in something because of what you have already invested, rather than based on its future value. In career terms: staying in a job you have outgrown because you have "already spent 4 years here," or continuing a career path that no longer fits because of the degree you paid for.</p>
<p><strong>Counter:</strong> Ask only forward-looking questions. "Ignoring everything I have already invested, is this the best path for my next 3 years?" The past investment cannot be recovered regardless of your decision — make choices based only on future value.</p>

<h3>Status Quo Bias</h3>
<p>We disproportionately prefer the current state of affairs over change, even when change is clearly beneficial. This explains why professionals stay in underpaying roles for years, avoid negotiating salaries, and delay learning new skills despite knowing they are falling behind.</p>
<p><strong>Counter:</strong> Reframe inaction as a choice. "Staying in this role" is not the default — it is an active decision with consequences. Make the cost of inaction explicit.</p>

<h3>Dunning-Kruger Effect</h3>
<p>People with limited knowledge in a domain systematically overestimate their competence. People with genuine expertise systematically underestimate theirs. This creates a painful double bind: beginners are overconfident while experts are plagued with impostor syndrome.</p>
<p><strong>Counter:</strong> Seek specific, external feedback from people who have achieved what you are trying to achieve. Self-assessment is the least reliable source of calibration — a mentor or experienced peer is vastly more accurate.</p>

<h3>Confirmation Bias</h3>
<p>We instinctively seek information that confirms what we already believe and dismiss information that challenges it. In career decisions, this means selectively reading success stories that validate the path you have already chosen, while ignoring evidence of its limitations.</p>
<p><strong>Counter:</strong> Actively seek the strongest case against your current plan. If you are thinking of starting a startup, find the most compelling arguments for why most startups fail and evaluate them honestly. Steel-manning the opposition is a powerful antidote.</p>

<h3>Present Bias</h3>
<p>We systematically overvalue immediate rewards over future ones, even when the future reward is objectively much larger. This explains why people delay investing in skills, avoid difficult conversations about salary, and procrastinate on anything whose payoff is more than a few weeks away.</p>
<p><strong>Counter:</strong> Make future consequences vivid and present. Instead of "I should learn cloud architecture eventually," calculate the specific salary difference between your current path and the cloud-specialised path in 3 years. Concrete future numbers are much harder to discount than vague future benefit.</p>

<h3>Halo Effect</h3>
<p>One positive attribute of a person or company causes us to assume other positive attributes. In careers: assuming a prestigious company brand means the role will be a good learning experience, or that a charismatic interviewer signals a good management culture.</p>
<p><strong>Counter:</strong> Evaluate each attribute independently. Ask specific questions about day-to-day management, team dynamics, and growth trajectory — and talk to people who have worked there, not just the recruiting team.</p>

<p>A good mentor helps you notice your own cognitive blind spots before they become expensive decisions. <a href="/mentors">Find a career mentor on MentF.</a></p>
HTML,
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],

            [
                'title'   => 'Why Mentorship Works: The Psychology of Learning from Others',
                'slug'    => 'why-mentorship-works-psychology-of-learning',
                'excerpt' => 'Mentorship is not just useful — it is the way humans have transmitted complex skills for most of history. Here is the psychology that makes it the most effective learning format available.',
                'content' => <<<'HTML'
<p>Long before MOOCs, textbooks, or YouTube tutorials, humans learned complex skills the same way: by watching, imitating, and being corrected by someone who already knew. Mentorship is not a modern innovation — it is the default learning mechanism that formal education largely abandoned in the 20th century.</p>

<h3>Observational Learning and Mirror Neurons</h3>
<p>Neuroscientists discovered mirror neurons in the 1990s — brain cells that fire both when we perform an action and when we observe someone else performing it. This is the biological basis of observational learning: watching an expert perform activates similar neural pathways to performing yourself, accelerating skill acquisition far beyond what pure description can achieve.</p>
<p>This is why watching a mentor solve a real problem live is worth more than reading a hundred pages about how to approach that problem. The neural encoding is fundamentally different.</p>

<h3>The Zone of Proximal Development</h3>
<p>Psychologist Lev Vygotsky described the Zone of Proximal Development (ZPD) as the gap between what a learner can do independently and what they can do with expert guidance. Effective mentorship operates precisely in this zone — challenging you beyond your current ability while providing enough support to prevent failure.</p>
<p>Self-study is limited because it is difficult to consistently identify your own ZPD. A mentor who knows both the domain and your current level can position tasks and challenges at exactly the right difficulty — neither too easy to be boring nor too hard to be discouraging.</p>

<h3>Corrective Feedback vs Positive Reinforcement</h3>
<p>Research in skill acquisition consistently shows that corrective feedback — specific information about what went wrong and why — is more valuable than general praise for accelerating skill development. The challenge is that most people, given a choice, prefer positive feedback over corrective feedback. A good mentor provides honest corrective feedback in a way that feels supportive rather than critical.</p>
<p>This requires psychological safety — the confidence that mistakes will be used as learning opportunities, not as evidence of your inadequacy. The best mentorship relationships create this safety explicitly.</p>

<h3>Social Accountability and Identity</h3>
<p>Having a mentor creates a social commitment that dramatically increases follow-through on difficult learning goals. Multiple studies show that stating an intention to another person increases the probability of acting on it by 65–90% compared to private intention alone.</p>
<p>Beyond accountability, a mentor who has achieved what you want to achieve also provides a model for identity — demonstrating that the person you want to become is real and achievable, not just theoretical.</p>

<h3>Tacit Knowledge: The Transfer Problem</h3>
<p>Much of expert knowledge is tacit — implicit understanding that experts cannot easily articulate but that fundamentally shapes their performance. Tacit knowledge is almost impossible to transfer through books or videos. It transfers through apprenticeship: watching, doing alongside, receiving real-time feedback, and gradually internalising patterns that were never explicitly stated.</p>
<p>This is the irreducible advantage of mentorship over self-directed learning from written or recorded resources. The knowledge that cannot be put into words can only be transmitted through relationship.</p>

<p>The most effective investment you can make in your growth is a mentorship relationship with someone who has the tacit knowledge you need. <a href="/mentors">Find your mentor on MentF.</a></p>
HTML,
                'is_published' => true,
                'published_at' => now()->subDays(3),
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
            'mastering-natural-light-portrait-photography',
            'composition-rules-every-photographer-should-know',
            'smartphone-to-dslr-beginners-guide-photography',
            'legal-rights-freelancer-india',
            'understanding-employment-contract-clauses-india',
            'intellectual-property-basics-creators-entrepreneurs-india',
            'science-of-habit-formation-build-skills-that-stick',
            'cognitive-biases-sabotage-career-decisions',
            'why-mentorship-works-psychology-of-learning',
        ];

        DB::table('blog_posts')->whereIn('slug', $slugs)->delete();
    }
};
