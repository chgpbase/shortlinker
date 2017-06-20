<?php

namespace App\Http\Controllers;


use App\Services\UrlShortener;
use App\ShortLink;
use App\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShortLinkController extends Controller
{
    public function shorten(Request $request, UrlShortener $shortener)
    {
        $v = Validator::make($request->all(), ['url' => 'required|url', 'life_to' => 'nullable|date']);
        if (!$v->passes()) {
            return view('home', ['invalid' => $v->errors()->toArray()]);
        }

        $url = $request->get('url');
        $date = $request->get('life_to');
        if (!is_null($date)) {
            $date = new \DateTimeImmutable($date);
        }

        $shortLink = $shortener->shorten($url, $date);
        return view('shortlink', ['shortLink' => $shortLink]);
    }

    public function hit(string $short)
    {
        $v = ShortLink::where('short_link', $short)->first();
        if (!is_null($v->life_to) && strtotime($v->life_to) < time()) {
            abort(404);
        }
        $geoIp = \Torann\GeoIP\Facades\GeoIP::getLocation();
        $statistic = new Statistic([
            'link_id' => $v->id,
            'country' => $geoIp->country,
            'city' => $geoIp->city,
            'user_agent' => \Illuminate\Support\Facades\Request::server('HTTP_USER_AGENT'),
        ]);
        $statistic->save();
        return redirect($v->source_link);
    }

    public function statistic(string $short, string $key)
    {
        $v = ShortLink::where('short_link', $short)->first();
        if ($key !== $v->getStatisticKey()) {
            abort(403);
        }
        $stat = Statistic::where('link_id', $v->id)->get();
        return view('stat', ['data' => $stat]);
    }
}
