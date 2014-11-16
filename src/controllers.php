<?php
use ICFS\Model\Page;
use Symfony\Component\HttpFoundation\Response;
use ICFS\Model\Events;
use Silex\Application;

$app->get('/', function (Application $app) {
    return $app['twig']->render('index.html');
});












$app->get('/join/tutee', function (Application $app) {
    return $app->redirect('/join/tutee/1');
});

$app->get('/join/tutee/1', function (Application $app) {
    if ($app['session']->get('username')) {
        return $app->redirect('/join/tutee/2');
    }
    return $app['twig']->render('reg_tutee/login.html');
});
$app->post('/join/tutee/1', function (Application $app) {
    if ($app['session']->get('username')) {
        return $app->redirect('/join/tutee/2');
    }

    if (function_exists('/pam_auth')) {
        $error = "exists";
    } else if (strlen($app['request']->get('uname')) < 1) {
        $error = "Invalid Username / Password";
    }

    if (!isset($error)) {
        $results = $app['db']->fetchAll("SELECT * from tutee WHERE username = ?", array($app['request']->get('uname')));
        if ($results) {
            $error = "You've already registered for the Tutoring Scheme; If you have any questions, please contact us.";
        } else {
            $app['session']->set('username', $app['request']->get('uname'));
        }
    }


    if (isset($error)) {
        return $app['twig']->render('reg_tutee/login.html', array(
            'error' => $error
        ));
    }

    return $app->redirect('/join/tutee/2');
});

$app->get('/join/tutee/2', function (Application $app) {
    if (strlen($app['session']->get('username')) == 0) {
        return $app->redirect('/join/tutee/1');
    }
    $results = $app['db']->fetchAll("SELECT * from tutee WHERE username = ?", array($app['session']->get('username')));
    if ($results) {
        return $app->redirect('/join/tutee/3');
    }


    return $app['twig']->render('reg_tutee/courseoptions.html', array(
        'username' => $app['session']->get('username')
    ));
});
$app->post('/join/tutee/2', function (Application $app) {
    if (!$app['session']->get('username')) {
        return $app->redirect('/join/tutee/1');
    }
    $results = $app['db']->fetchAll("SELECT * from tutee WHERE username = ?", array($app['session']->get('username')));
    if ($results) {
        return $app->redirect('/join/tutee/3');
    }

    $scores = $app['request']->get('courselevel');
    foreach ($app['request']->get('course') as $key => $course) {
        if ($course) {
            $app['db']->insert('tutee', array(
                'username' => $app['session']->get('username'),
                'course' => $course,
                'level' => $scores[$key]
            ));
        }
    }

    return $app->redirect('/join/tutee/3');
});

$app->get('/join/tutee/3', function (Application $app) {
    $results = $app['db']->fetchAll("SELECT * from tutee WHERE username = ?", array($app['session']->get('username')));
    if (!$results) {
        return $app->redirect('/join/tutor/1');
    }
    return $app['twig']->render('reg_tutee/thanks.html', array(
        'username' => $app['session']->get('username')
    ));
});








$app->get('/join/tutor', function (Application $app) {
    return $app->redirect('/join/tutor/1');
});
$app->get('/join/tutor/1', function (Application $app) {
    if ($app['session']->get('username')) {
        return $app->redirect('/join/tutor/2');
    }
    return $app['twig']->render('reg_tutor/login.html');
});
$app->post('/join/tutor/1', function (Application $app) {
    if ($app['session']->get('username')) {
        return $app->redirect('/join/tutor/2');
    }

    if (function_exists('/pam_auth')) {
        $error = "exists";
    } else if (strlen($app['request']->get('uname')) < 1) {
        $error = "Invalid Username / Password";
    }

    if (!isset($error)) {
        $results = $app['db']->fetchAll("SELECT * from tutor WHERE username = ?", array($app['request']->get('uname')));
        if ($results) {
            $error = "You've already registered for the Tutoring Scheme; If you have any questions, please contact us.";
        } else {
            $app['session']->set('username', $app['request']->get('uname'));
        }
    }


    if (isset($error)) {
        return $app['twig']->render('reg_tutor/login.html', array(
            'error' => $error
        ));
    }

    return $app->redirect('/join/tutor/2');
});

$app->get('/join/tutor/2', function (Application $app) {
    if (strlen($app['session']->get('username')) == 0) {
        return $app->redirect('/join/tutor/1');
    }
    $results = $app['db']->fetchAll("SELECT * from tutor WHERE username = ?", array($app['session']->get('username')));
    if ($results) {
        return $app->redirect('/join/tutor/3');
    }


    return $app['twig']->render('reg_tutor/courseoptions.html', array(
        'username' => $app['session']->get('username')
    ));
});
$app->post('/join/tutor/2', function (Application $app) {
    if (strlen($app['session']->get('username')) == 0) {
        return $app->redirect('/join/tutor/1');
    }
    $results = $app['db']->fetchAll("SELECT * from tutor WHERE username = ?", array($app['session']->get('username')));
    if ($results) {
        return $app->redirect('/join/tutor/3');
    }

    $scores = $app['request']->get('courselevel');
    foreach ($app['request']->get('course') as $key => $course) {
        if ($course) {
            $app['db']->insert('tutor', array(
                'username' => $app['session']->get('username'),
                'course' => $course,
                'level' => $scores[$key]
            ));
        }
    }

    return $app->redirect('/join/tutor/3');
});

$app->get('/join/tutor/3', function (Application $app) {
    $results = $app['db']->fetchAll("SELECT * from tutor WHERE username = ?", array($app['session']->get('username')));
    if (!$results) {
        return $app->redirect('/join/tutor/1');
    }
    return $app['twig']->render('reg_tutor/thanks.html', array(
        'username' => $app['session']->get('username')
    ));
});