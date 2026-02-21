<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create 3 administrators
        $admins = [];
        $adminNames = ['John Admin', 'Sarah Manager', 'Mike Organizer'];
        
        foreach ($adminNames as $index => $name) {
            $admins[] = User::create([
                'name' => $name,
                'email' => $index === 0 ? 'admin@cems.local' : strtolower(str_replace(' ', '.', $name)) . '@cems.local',
                'password' => Hash::make('password'),
                'role' => 'administrator',
                'email_verified_at' => now(),
            ]);
        }

        // Create 30 students with realistic names
        $students = [];
        $firstNames = ['Emma', 'Liam', 'Olivia', 'Noah', 'Ava', 'Ethan', 'Sophia', 'Mason', 'Isabella', 'William',
                       'Mia', 'James', 'Charlotte', 'Benjamin', 'Amelia', 'Lucas', 'Harper', 'Henry', 'Evelyn', 'Alexander',
                       'Abigail', 'Michael', 'Emily', 'Daniel', 'Elizabeth', 'Matthew', 'Sofia', 'Jackson', 'Avery', 'David'];
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez',
                      'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson', 'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin',
                      'Lee', 'Perez', 'Thompson', 'White', 'Harris', 'Sanchez', 'Clark', 'Ramirez', 'Lewis', 'Robinson'];

        foreach ($firstNames as $index => $firstName) {
            $fullName = $firstName . ' ' . $lastNames[$index];
            $email = $index === 0 ? 'student@cems.local' : strtolower($firstName . '.' . $lastNames[$index]) . '@cems.local';
            
            $students[] = User::create([
                'name' => $fullName,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'student',
                'email_verified_at' => now(),
            ]);
        }

        // Event categories and details
        $categories = ['Workshop', 'Seminar', 'Conference', 'Social', 'Sports', 'Cultural', 'Academic', 'Career'];
        
        $eventTemplates = [
            ['title' => 'Web Development Workshop', 'category' => 'Workshop', 'description' => 'Learn modern web development with React and Laravel. Hands-on coding session for beginners and intermediate developers.'],
            ['title' => 'Career Fair 2024', 'category' => 'Career', 'description' => 'Meet top employers and explore career opportunities. Bring your resume and dress professionally.'],
            ['title' => 'AI & Machine Learning Seminar', 'category' => 'Seminar', 'description' => 'Discover the latest trends in artificial intelligence and machine learning applications.'],
            ['title' => 'Campus Music Festival', 'category' => 'Cultural', 'description' => 'Annual music festival featuring student bands and guest performers. Food and drinks available.'],
            ['title' => 'Basketball Tournament Finals', 'category' => 'Sports', 'description' => 'Cheer for your team in the championship game. Free entry for all students.'],
            ['title' => 'Entrepreneurship Conference', 'category' => 'Conference', 'description' => 'Learn from successful entrepreneurs and network with startup founders.'],
            ['title' => 'Photography Exhibition', 'category' => 'Cultural', 'description' => 'Showcase of student photography work. Opening reception with refreshments.'],
            ['title' => 'Python Programming Bootcamp', 'category' => 'Workshop', 'description' => 'Intensive 3-hour bootcamp covering Python basics to advanced topics.'],
            ['title' => 'Mental Health Awareness Week', 'category' => 'Social', 'description' => 'Join us for activities and discussions promoting mental health and wellness.'],
            ['title' => 'Research Symposium', 'category' => 'Academic', 'description' => 'Students present their research projects. Open to all disciplines.'],
            ['title' => 'International Food Festival', 'category' => 'Cultural', 'description' => 'Taste cuisines from around the world prepared by international students.'],
            ['title' => 'Hackathon 2024', 'category' => 'Workshop', 'description' => '24-hour coding competition with prizes. Form teams or join solo.'],
            ['title' => 'Guest Lecture: Climate Change', 'category' => 'Seminar', 'description' => 'Renowned climate scientist discusses global warming and sustainability.'],
            ['title' => 'Dance Competition', 'category' => 'Cultural', 'description' => 'Showcase your dance skills. Solo and group categories available.'],
            ['title' => 'Yoga and Meditation Session', 'category' => 'Social', 'description' => 'Relax and de-stress with guided yoga and meditation. All levels welcome.'],
            ['title' => 'Cybersecurity Workshop', 'category' => 'Workshop', 'description' => 'Learn about online security, ethical hacking, and data protection.'],
            ['title' => 'Alumni Networking Event', 'category' => 'Career', 'description' => 'Connect with successful alumni and learn about career paths.'],
            ['title' => 'Film Screening: Documentary', 'category' => 'Cultural', 'description' => 'Award-winning documentary followed by Q&A with the director.'],
            ['title' => 'Science Fair', 'category' => 'Academic', 'description' => 'Student science projects on display. Judging and awards ceremony.'],
            ['title' => 'Volunteer Day', 'category' => 'Social', 'description' => 'Give back to the community. Various volunteer opportunities available.'],
            ['title' => 'Gaming Tournament', 'category' => 'Sports', 'description' => 'Esports competition featuring popular games. Prizes for winners.'],
            ['title' => 'Public Speaking Workshop', 'category' => 'Workshop', 'description' => 'Improve your presentation and communication skills.'],
            ['title' => 'Art & Craft Fair', 'category' => 'Cultural', 'description' => 'Buy handmade items from student artists and crafters.'],
            ['title' => 'Mock Interview Sessions', 'category' => 'Career', 'description' => 'Practice interviews with industry professionals. Get feedback.'],
            ['title' => 'Sustainability Summit', 'category' => 'Conference', 'description' => 'Discuss environmental issues and sustainable campus initiatives.'],
        ];

        $locations = [
            'Main Auditorium', 'Student Center Room 101', 'Library Conference Hall', 'Sports Complex',
            'Engineering Building Lab 3', 'Arts Center Theater', 'Campus Quad', 'Science Building Room 205',
            'Business School Auditorium', 'Student Union Hall', 'Outdoor Amphitheater', 'Gymnasium',
            'Music Hall', 'Computer Lab A', 'Lecture Hall 1', 'Cafeteria Event Space'
        ];

        $events = [];
        foreach ($eventTemplates as $index => $template) {
            $daysOffset = rand(-5, 45); // Some past events, mostly future
            $startTime = now()->addDays($daysOffset)->setHour(rand(9, 18))->setMinute([0, 30][rand(0, 1)]);
            $duration = rand(1, 4);
            
            $status = 'published';
            if ($daysOffset < 0) {
                $status = 'published'; // Past events
            } elseif ($index % 8 === 0) {
                $status = 'draft'; // Some draft events
            } elseif ($index % 9 === 0) {
                $status = 'cancelled'; // Some cancelled events
            }

            $capacity = [20, 30, 50, 75, 100, 150, 200][rand(0, 6)];
            
            $events[] = Event::create([
                'title' => $template['title'],
                'description' => $template['description'],
                'start_time' => $startTime,
                'end_time' => $startTime->copy()->addHours($duration),
                'location' => $locations[array_rand($locations)],
                'location_type' => ($index % 4 === 0) ? 'virtual' : 'physical',
                'capacity' => $capacity,
                'category' => $template['category'],
                'organizer_id' => $admins[array_rand($admins)]->id,
                'status' => $status,
            ]);
        }

        // Create registrations for published events
        $publishedEvents = collect($events)->filter(fn($e) => $e->status === 'published');
        
        foreach ($publishedEvents as $event) {
            // Register random number of students (30-80% of capacity)
            $registrationCount = rand((int)($event->capacity * 0.3), (int)($event->capacity * 0.8));
            $selectedStudents = collect($students)->random(min($registrationCount, count($students)));

            foreach ($selectedStudents as $student) {
                $registration = Registration::create([
                    'user_id' => $student->id,
                    'event_id' => $event->id,
                    'status' => 'registered',
                ]);

                // Mark some as attended for past events
                if ($event->start_time->isPast() && rand(0, 100) > 20) {
                    $registration->update([
                        'status' => 'attended',
                        'attended_at' => $event->start_time->copy()->addMinutes(rand(0, 30)),
                    ]);
                }
            }
        }

        // Create some audit log entries
        AuditLog::create([
            'user_id' => $admins[0]->id,
            'action' => 'event.created',
            'model_type' => Event::class,
            'model_id' => $events[0]->id,
            'new_values' => json_encode(['title' => $events[0]->title]),
        ]);
    }
}
