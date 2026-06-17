<?php
// about.php
$page_title       = 'About Us | Saksham Bharti';
$page_description = 'Learn about Saksham Bharti — our 25-year journey, vision, mission, and the dedicated team driving skill development for underprivileged youth in New Delhi.';
require_once 'includes/header.php';
?>

<div class="container py-5">
<div class="row mb-5">
  <div class="col-md-12 text-center">
    <h1 class="fw-bold text-primary display-4">About Saksham Bharti</h1>
    <p class="lead text-muted">From Incompetence to Competence — Aksham se Saksham</p>
  </div>
</div>

<!-- Vision & Mission Section -->
<div class="row mb-5 g-4">
    <div class="col-md-6">
        <div class="card h-100 border-0 shadow-sm rounded-4 p-4 p-lg-5" style="background: linear-gradient(135deg, #1f327f 0%, #3a51b5 100%); color: #fff;">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-white bg-opacity-25 p-3 rounded-circle me-3">
                    <i class="fas fa-eye fa-2x"></i>
                </div>
                <h2 class="fw-bold mb-0">Our Vision</h2>
            </div>
            <p class="lead mb-0" style="line-height: 1.8;">
                To create a prosperous, value-based and a harmonious society, where the opportunities are available to the last man in the row.
            </p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100 border-0 shadow-sm rounded-4 p-4 p-lg-5" style="background: linear-gradient(135deg, #f4a020 0%, #ffc107 100%); color: #fff;">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-white bg-opacity-25 p-3 rounded-circle me-3">
                    <i class="fas fa-bullseye fa-2x"></i>
                </div>
                <h2 class="fw-bold mb-0">Our Mission</h2>
            </div>
            <p class="lead mb-0" style="line-height: 1.8;">
                Empowering marginalized communities through skill development, employability, holistic development, and empowering youth and women.
            </p>
        </div>
    </div>
</div>

<!-- Our Legacy Section -->
<div class="row mb-5 py-4 bg-light rounded-4 shadow-sm align-items-center">
    <div class="col-md-7 px-5">
        <h2 class="fw-bold text-primary mb-3">Our Journey & Legacy</h2>
        <p>
            Established in the year <strong>2000</strong> and registered under the Registration of Societies Act, Saksham Bharti was born from a simple yet powerful vision: to bridge the gap between unemployment and opportunity.
        </p>
        <p>
            Founded by a group of dedicated professionals, we have spent <strong>25 years</strong> transforming lives through our core philosophy of <strong>"Aksham se Saksham"</strong> (From Incompetence to Competence). We believe that true development is only possible when every individual is equipped with the skills to be self-reliant.
        </p>
    </div>
    <div class="col-md-5 text-center p-4">
        <div class="p-4 rounded-4 shadow-lg text-white border-0" style="background: linear-gradient(135deg, #f4a020 0%, #ffc107 100%);">
            <h1 class="display-3 fw-bold mb-0">25</h1>
            <p class="text-uppercase fw-bold mb-0">Years of Excellence</p>
        </div>
    </div>
</div>



<!-- SDGs Alignment -->
<div class="row mb-5 py-5 bg-white rounded-4 shadow-sm" id="sdgs">
    <div class="col-12 text-center mb-4">
        <h2 class="fw-bold text-primary">Alignment with Sustainable Development Goals</h2>
        <p class="text-muted">Saksham Bharti aligns with <strong>10 United Nations SDGs</strong> to drive holistic development and foster a sustainable and inclusive future.</p>
    </div>
    <div class="col-12">
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <span class="badge rounded-pill bg-danger text-white shadow-sm p-3"><i class="fas fa-hand-holding-heart me-2"></i>Goal 1: No Poverty</span>
            <span class="badge rounded-pill bg-primary text-white shadow-sm p-3"><i class="fas fa-book-reader me-2"></i>Goal 4: Quality Education</span>
            <span class="badge rounded-pill bg-info text-white shadow-sm p-3"><i class="fas fa-balance-scale me-2"></i>Goal 5: Gender Equality</span>
            <span class="badge rounded-pill text-white shadow-sm p-3" style="background-color:#00b4d8;"><i class="fas fa-tint me-2"></i>Goal 6: Clean Water & Sanitation</span>
            <span class="badge rounded-pill text-white shadow-sm p-3" style="background-color:#f9c74f; color:#000 !important;"><i class="fas fa-solar-panel me-2"></i>Goal 7: Affordable & Clean Energy</span>
            <span class="badge rounded-pill bg-success text-white shadow-sm p-3"><i class="fas fa-chart-line me-2"></i>Goal 8: Decent Work & Growth</span>
            <span class="badge rounded-pill bg-warning text-dark shadow-sm p-3"><i class="fas fa-recycle me-2"></i>Goal 12: Responsible Consumption</span>
            <span class="badge rounded-pill text-white shadow-sm p-3" style="background-color:#2d6a4f;"><i class="fas fa-cloud me-2"></i>Goal 13: Climate Action</span>
            <span class="badge rounded-pill text-white shadow-sm p-3" style="background-color:#52b788;"><i class="fas fa-tree me-2"></i>Goal 15: Life on Land</span>
            <span class="badge rounded-pill bg-secondary text-white shadow-sm p-3"><i class="fas fa-handshake me-2"></i>Goal 17: Partnerships for Goals</span>
        </div>
    </div>
</div>

<!-- Message from President Section -->
<div class="row mb-5 g-0 president-section shadow-sm border">
    <!-- Image/Bio Column -->
    <div class="col-lg-4 bg-light p-5 text-center d-flex flex-column justify-content-center border-end">
        <div class="president-portrait-container mb-4">
            <img src="assets/images/president_rajeev.png" class="president-portrait-img" alt="Rajeev Kumar Kalra">
        </div>
        <h3 class="fw-bold text-primary mb-0">Rajeev Kumar Kalra</h3>
        <p class="text-secondary fw-bold text-uppercase small ls-1">President, Saksham Bharti</p>
        <hr class="w-25 mx-auto border-secondary opacity-50 my-3">
        <p class="text-muted small px-3">"Leading with a mission to empower marginalized communities through education and dignified self-reliance."</p>
    </div>

    <!-- Message Content Column -->
    <div class="col-lg-8 p-4 p-md-5 bg-white position-relative">
        <i class="fas fa-quote-left quote-icon"></i>
        
        <div class="pe-md-4">
            <h2 class="fw-bold text-primary mb-4">Message from the President</h2>
            
            <p class="text-muted mb-4" style="line-height: 1.8;">
                As I reflect on the journey of the past year, my heart is filled with gratitude and pride. Saksham Bharti has continued to move forward with renewed energy, touching lives and creating opportunities where they are needed the most.
            </p>
            
            <h5 class="fw-bold text-secondary mb-3">Our Core Areas of Impact</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6 text-start">
                    <div class="impact-badge">
                        <h6 class="fw-bold mb-1"><i class="fas fa-tools me-2"></i> Skill Training</h6>
                        <p class="small text-muted mb-0">Market-relevant skills securing stable employment.</p>
                    </div>
                </div>
                <div class="col-md-6 text-start">
                    <div class="impact-badge">
                        <h6 class="fw-bold mb-1"><i class="fas fa-laptop-code me-2"></i> Digital Fluency</h6>
                        <p class="small text-muted mb-0">Empowering youth to navigate the digital world.</p>
                    </div>
                </div>
                <div class="col-md-6 text-start">
                    <div class="impact-badge">
                        <h6 class="fw-bold mb-1"><i class="fas fa-lightbulb me-2"></i> Entrepreneurship</h6>
                        <p class="small text-muted mb-0">Turning ideas into thriving small businesses.</p>
                    </div>
                </div>
                <div class="col-md-6 text-start">
                    <div class="impact-badge">
                        <h6 class="fw-bold mb-1"><i class="fas fa-brain me-2"></i> Emotional Intelligence</h6>
                        <p class="small text-muted mb-0">Building confidence and leadership abilities.</p>
                    </div>
                </div>
            </div>

            <p class="text-muted mb-4" style="line-height: 1.8;">
                Our partnerships with organizations like <strong>NIIT Foundation</strong> and <strong>Magic Bus</strong> have grown stronger, preparing youth for the digital economy. We have also opened many new centers, including our recent one at <strong>Nangloi, New Delhi</strong>.
            </p>
            
            <p class="text-muted mb-4" style="line-height: 1.8;">
                Every student who secures a job and every family that begins to dream bigger is a testament to the power of our collective effort. Let us move forward with the same spirit of service and commitment.
            </p>

            <div class="mt-5">
                <p class="mb-1 text-muted">With gratitude and determination,</p>
                <p class="signature-font mb-0">Rajeev Kumar Kalra</p>
                <p class="text-muted small">President, Saksham Bharti</p>
            </div>
        </div>
    </div>
</div>

<!-- Who We Are & Target Demographic -->
<div class="row mb-5 align-items-center">
  <div class="col-md-6">
    <h2 class="fw-bold text-primary">Focused Empowerment</h2>
    <p>
      At the heart of Saksham Bharti's operations is a specialized focus on the <strong>youth in the age group of 17 to 23 years</strong>. We identify this as a critical transition period where the right guidance and skill-set can rewrite a person's entire future.
    </p>
    <p>
      While our vocational training primarily serves this demographic, our broader mission remains inclusive. We provide scholarship programs based on <strong>needs-cum-merit</strong> for students ranging from primary school all the way through higher education.
    </p>
    <div class="bg-primary text-white p-4 rounded-4 mt-4 shadow-sm">
        <h5 class="fw-bold"><i class="fas fa-check-circle me-2 text-secondary"></i> How We Work</h5>
        <ul class="list-unstyled mb-0">
            <li class="mb-2"><strong>Enrollment:</strong> Identifying meritorious but underprivileged candidates.</li>
            <li class="mb-2"><strong>Training:</strong> Industry-standard vocational courses.</li>
            <li class="mb-2"><strong>Mentoring:</strong> Continuous hand-holding and career counseling.</li>
            <li><strong>Placement:</strong> Direct link to industry through job fairs like 'Aajeevika Mahotsav'.</li>
        </ul>
    </div>
  </div>

  <div class="col-md-6 text-center mt-4 mt-md-0">
    <img src="assets/images/about_who_we_are.png" class="img-fluid rounded shadow" alt="Saksham Bharti Team" style="max-width: 450px;">
    <p class="mt-3 text-muted fst-italic italic small">Empowering the youth through skill-focused vocational training.</p>
  </div>
</div>



<!-- Comprehensive Support -->
<div class="row mt-5 mb-5">
  <div class="col-md-12 bg-light p-5 rounded-4 border-start border-5 border-primary">
    <h3 class="fw-bold text-primary mb-4 text-center">A Holistic Ecosystem of Growth</h3>
    <p>
      Saksham Bharti provides more than just training; we provide an ecosystem. Our vocational courses in computer education, stitching, beauty culture, and soft skills are supported by over **250+ volunteers** from diverse professional backgrounds. 
    </p>
    <p class="mb-0">
      From organizing the **Swami Vivekananda Aajeevika Mahotsav** (Job Fairs) to providing pre-admission mentoring, we ensure that the "fruits of development" are accessible to the "last man in the row." We don't just teach skills; we nurture entrepreneurial mindsets that drive long-term community change.
    </p>
  </div>
</div>

<!-- Core Members Section -->
<?php
$members = [
    [
        'name' => 'Rajeev Kumar Kalra',
        'role' => 'President',
        'image' => 'assets/images/member_rajeev.png'
    ],
    [
        'name' => 'Dipti Chawla',
        'role' => 'General Secretary',
        'image' => 'assets/images/member_dipti.png'
    ],
    [
        'name' => 'Deepak Arora',
        'role' => 'Vice President',
        'image' => 'assets/images/member_deepak.png'
    ],
    [
        'name' => 'Neeraj Rana Sharma',
        'role' => 'Vice President',
        'image' => 'assets/images/member_neeraj.png'
    ],
    [
        'name' => 'Gaurav Ahuja',
        'role' => 'Vice President',
        'image' => 'assets/images/member_gaurav.png'
    ],
    [
        'name' => 'Narendra Vishwakarma',
        'role' => 'Vice President',
        'image' => 'assets/images/member_narendra.png'
    ],
    [
        'name' => 'Hervinder Singh',
        'role' => 'Treasurer',
        'image' => 'assets/images/member_hervinder.png'
    ],
    [
        'name' => 'Kanwar Verma',
        'role' => 'Secretary',
        'image' => 'assets/images/member_kanwar.png'
    ],
    [
        'name' => 'Pradeep Kumar Mehrotra',
        'role' => 'Secretary',
        'image' => 'assets/images/member_pradeep.png'
    ],
    [
        'name' => 'Dr. Pratibha Gogia',
        'role' => 'Secretary',
        'image' => 'assets/images/member_pratibha.png'
    ],
    [
        'name' => 'Ripudaman Kalra',
        'role' => 'Secretary',
        'image' => 'assets/images/member_ripudaman.png'
    ],
    [
        'name' => 'Ram Milan Yadav',
        'role' => 'Secretary',
        'image' => 'assets/images/member_rammilan.png'
    ],
    [
        'name' => 'Sunil Kumar',
        'role' => 'Executive Member',
        'image' => 'assets/images/member_sunil.png'
    ],
    [
        'name' => 'Medhavi Anand',
        'role' => 'Executive Member',
        'image' => 'assets/images/member_medhavi.png'
    ],
    [
        'name' => 'Rekha',
        'role' => 'Executive Member',
        'image' => 'assets/images/member_rekha.png'
    ],
    [
        'name' => 'Sukriti Kalra',
        'role' => 'Executive Member',
        'image' => 'assets/images/member_sukriti.png'
    ],
    [
        'name' => 'Suresh Sabharwal',
        'role' => 'Executive Member',
        'image' => 'assets/images/member_suresh.png'
    ],
    [
        'name' => 'Dr. Vinod Anand',
        'role' => 'Executive Member',
        'image' => 'assets/images/member_vinod.png'
    ],
    [
        'name' => 'Vaaruni Bhasin',
        'role' => 'Executive Member',
        'image' => 'assets/images/member_vaaruni.png'
    ],
    [
        'name' => 'Rupali Agarwal',
        'role' => 'Executive Member',
        'image' => 'assets/images/member_rupali.png'
    ],
    [
        'name' => 'Sudhir Kr. Sehra',
        'role' => 'Executive Member',
        'image' => 'assets/images/member_sudhir.png'
    ],
    [
        'name' => 'Subhash Malik',
        'role' => 'Executive Member',
        'image' => 'assets/images/member_subhash.png'
    ],
    [
        'name' => 'Raghu Kalra',
        'role' => 'Executive Member',
        'image' => 'assets/images/member_raghu.png'
    ],
    [
        'name' => 'P Bala ji',
        'role' => 'Executive Member',
        'image' => 'assets/images/member_balaji.png'
    ],
    [
        'name' => 'Anindita Roy',
        'role' => 'Executive Member',
        'image' => 'assets/images/member_anindita.png'
    ],
    [
        'name' => 'Ankur Arora',
        'role' => 'Executive Member',
        'image' => 'assets/images/member_ankur.png'
    ],
    [
        'name' => 'Gaurav Kathuria',
        'role' => 'Executive Member',
        'image' => 'assets/images/member_gaurav_k.png'
    ],
    [
        'name' => 'Rajesh Bhagat',
        'role' => 'Executive Member',
        'image' => 'assets/images/member_rajesh.png'
    ],
    [
        'name' => 'Kritika Hora',
        'role' => 'Executive Member',
        'image' => 'assets/images/member_kritika.png'
    ]
];
?>

<div class="row mt-5">
    <div class="col-12 text-center mb-5">
        <h2 class="fw-bold text-primary display-5">Our Core Members</h2>
        <p class="lead text-muted">The dedicated leadership driving our mission forward.</p>
    </div>
    
    <div class="col-12">
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
            <?php foreach ($members as $member): ?>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm text-center p-4 rounded-4 hover-lift transition-all">
                        <div class="member-avatar-container mb-3 mx-auto" style="width: 100px; height: 100px; overflow: hidden; border-radius: 50%;">
                            <?php if (!empty($member['image'])): ?>
                                <img src="<?= htmlspecialchars($member['image']) ?>" class="w-100 h-100 shadow-sm" alt="<?= htmlspecialchars($member['name']) ?>" style="object-fit: cover; object-position: center;">
                            <?php else: ?>
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light rounded-circle" style="border: 1px solid #e9ecef;">
                                    <i class="fas fa-user fa-2x text-secondary opacity-50"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <h5 class="fw-bold text-primary mb-1"><?= htmlspecialchars($member['name']) ?></h5>
                        <p class="text-muted small mb-0"><?= htmlspecialchars($member['role']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        </div>
    </div>
</div>

<!-- Silver Jubilee Testimonials Section -->
<div class="bg-light py-5 my-5 border-top border-bottom">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-secondary rounded-pill px-3 py-2 text-uppercase fw-bold mb-2">25 Years of Seva</span>
            <h2 class="fw-bold text-primary display-5">Silver Jubilee Well-Wishers</h2>
            <p class="lead text-muted">Words of encouragement and appreciation from our supporters & well-wishers.</p>
        </div>
        
        <div class="row g-4">
            <!-- Testimonial 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-white position-relative">
                    <i class="fas fa-quote-left text-primary opacity-10 position-absolute end-0 bottom-0 me-3 mb-2" style="font-size: 4rem;"></i>
                    <p class="text-muted fst-italic mb-4" style="line-height: 1.6;">"Over 25 years, Saksham Bharti has embraced a youthful spirit — and through their tireless dedication and efforts, its founders and members too defy age and continue to remain forever young."</p>
                    <div class="mt-auto">
                        <h6 class="fw-bold text-primary mb-0">Jyotika Kalra</h6>
                        <small class="text-muted">Well-wisher</small>
                    </div>
                </div>
            </div>
            <!-- Testimonial 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-white position-relative">
                    <i class="fas fa-quote-left text-primary opacity-10 position-absolute end-0 bottom-0 me-3 mb-2" style="font-size: 4rem;"></i>
                    <p class="text-muted fst-italic mb-4" style="line-height: 1.6;">"Wishing Saksham Bharti a very Happy 25th Anniversary! Grateful for the incredible journey and the lives touched along the way. Let’s continue working together towards the mission of ‘Aksham Se Saksham’."</p>
                    <div class="mt-auto">
                        <h6 class="fw-bold text-primary mb-0">Narender</h6>
                        <small class="text-muted">Well-wisher</small>
                    </div>
                </div>
            </div>
            <!-- Testimonial 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-white position-relative">
                    <i class="fas fa-quote-left text-primary opacity-10 position-absolute end-0 bottom-0 me-3 mb-2" style="font-size: 4rem;"></i>
                    <p class="text-muted fst-italic mb-4" style="line-height: 1.6;">"Best wishes to the entire Saksham Bharti team — proud to witness 25 years of impactful work and unity. A silver jubilee that reflects thousands of transformed lives."</p>
                    <div class="mt-auto">
                        <h6 class="fw-bold text-primary mb-0">Neeraj Sharma</h6>
                        <small class="text-muted">Well-wisher</small>
                    </div>
                </div>
            </div>
            <!-- Testimonial 4 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-white position-relative">
                    <i class="fas fa-quote-left text-primary opacity-10 position-absolute end-0 bottom-0 me-3 mb-2" style="font-size: 4rem;"></i>
                    <p class="text-muted fst-italic mb-4" style="line-height: 1.6;">"Congratulations to Saksham Bharti for 25 inspiring years of dedication and service — a truly commendable journey of resilience, compassion, and empowerment."</p>
                    <div class="mt-auto">
                        <h6 class="fw-bold text-primary mb-0">MP Gogia</h6>
                        <small class="text-muted">Well-wisher</small>
                    </div>
                </div>
            </div>
            <!-- Testimonial 5 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-white position-relative">
                    <i class="fas fa-quote-left text-primary opacity-10 position-absolute end-0 bottom-0 me-3 mb-2" style="font-size: 4rem;"></i>
                    <p class="text-muted fst-italic mb-4" style="line-height: 1.6;">"SB standing tall at 25, striding to 50. Celebrating 25 years of Saksham Bharti – a journey of resilience, compassion, and empowerment."</p>
                    <div class="mt-auto">
                        <h6 class="fw-bold text-primary mb-0">Deepak Arora & Dr. Pratibha Gogia</h6>
                        <small class="text-muted">Core Committee Members</small>
                    </div>
                </div>
            </div>
            <!-- Testimonial 6 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-white position-relative">
                    <i class="fas fa-quote-left text-primary opacity-10 position-absolute end-0 bottom-0 me-3 mb-2" style="font-size: 4rem;"></i>
                    <p class="text-muted fst-italic mb-4" style="line-height: 1.6;">"Congratulations to the entire team and family of Saksham Bharti. May the journey continue to bring smiles on millions of faces."</p>
                    <div class="mt-auto">
                        <h6 class="fw-bold text-primary mb-0">Mukesh Jain</h6>
                        <small class="text-muted">Well-wisher</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Annual Report Section -->
<div class="container py-5 mb-5 border-top pt-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Annual Report</h2>
        <p class="lead text-muted">Transparency and accountability are our core values.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10 text-center">
            <div class="card border-0 shadow-lg rounded-4 p-5 text-center bg-light border-top border-5 border-primary">
                <i class="fas fa-file-pdf display-1 text-danger mb-4"></i>
                <h3 class="fw-bold mb-3">Saksham Bharti Annual Report 2024-25</h3>
                <p class="text-muted mb-4 px-md-5">Read about our achievements, financial statements, and the progress we've made towards our goals over the past year.</p>
                <a href="assets/reports/Saksham_Bharti_Annual_Report_2024-25.pdf" target="_blank" class="btn btn-primary rounded-pill px-4 me-2"><i class="fas fa-eye me-2"></i> View Report</a>
                <a href="assets/reports/Saksham_Bharti_Annual_Report_2024-25.pdf" download class="btn btn-outline-secondary rounded-pill px-4"><i class="fas fa-download me-2"></i> Download PDF</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
